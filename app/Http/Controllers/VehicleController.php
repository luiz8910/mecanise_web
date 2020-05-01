<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository;
use App\Repositories\ColorsRepository;
use App\Repositories\PersonRepository;
use App\Repositories\StatesRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\WorkshopRepository;
use App\Traits\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Psr\Container\NotFoundExceptionInterface;

class VehicleController extends Controller
{
    use Config;

    private $repository;
    private $personRepository;
    /**
     * @var CarRepository
     */
    private $carRepository;
    /**
     * @var WorkshopRepository
     */
    private $workshopRepository;
    /**
     * @var StatesRepository
     */
    private $statesRepository;
    /**
     * @var ColorsRepository
     */
    private $colorsRepository;

    public function __construct(VehicleRepository $repository, PersonRepository $personRepository,
                                CarRepository $carRepository, WorkshopRepository $workshopRepository,
                                StatesRepository $statesRepository, ColorsRepository $colorsRepository)
    {

        $this->repository = $repository;
        $this->personRepository = $personRepository;
        $this->carRepository = $carRepository;
        $this->workshopRepository = $workshopRepository;
        $this->statesRepository = $statesRepository;
        $this->colorsRepository = $colorsRepository;
    }

    /**
     * List all vehicle in workshop
     * @return View
     */
    public function index()
    {
        $vehicles = $this->repository->findByField('workshop_id', $this->get_user_workshop());

        $workshop = $this->workshopRepository->findByField('id', $this->get_user_workshop())->first();

        if($workshop)
        {
            $scripts[] = '../../js/vehicle.js';

            $route = 'vehicles.index';

            foreach ($vehicles as $vehicle)
            {
                $car = $this->carRepository->findByField('id', $vehicle->car_id)->first();

                if($car) {

                    $vehicle->model = $car->model;

                    $vehicle->brand = $car->brand;

                    $vehicle->owner_name = $this->personRepository->findByField('id', $vehicle->owner_id)->first()->name;
                }
            }

            return view('index', compact('vehicles', 'route', 'scripts'));
        }


    }

    /**
     * List all vehicles by owner
     * @param $owner_id
     * @return View
     */
    public function vehicle_by_owner($owner_id)
    {
        $vehicles = $this->repository->findByField('owner_id', $owner_id);

        $route = 'vehicles.by_owner';

        return view('index', compact('vehicles', 'route'));
    }

    /**
     * Create a new vehicle
     * @return View
     */
    public function create()
    {
        $cars =  $this->carRepository->all();

        $brands = DB::table('cars')
                        ->whereNull('deleted_at')
                        ->select('brand')
                        ->distinct()
                        ->get();


        $route = 'vehicles.form';

        $edit = false;

        $owners = $this->personRepository->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => 4]);

        $states = $this->statesRepository->orderBy('state')->all();

        $colors = $this->colorsRepository->orderBy('name')->all();

        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../js/zipcode.js';
        $scripts[] = '../../js/mask.js';

        return view('index', compact('cars', 'route', 'scripts',
            'edit', 'brands', 'states', 'owners', 'colors'));
    }

    /**
     * Edit selected vehicle
     * @param $id
     */
    public function edit($id)
    {
        $cars = $brands = $this->carRepository->all();

        $route = 'vehicles.form';

        $edit = true;

        $states = $this->statesRepository->orderBy('state')->all();

        $links[] = '../../assets/css/pages/wizard/wizard-4.css';

        //$scripts[] = '../../assets/js/pages/custom/user/add-user.js';
        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../assets/js/pages/crud/forms/widgets/bootstrap-maxlength.js';
        $scripts[] = '../../assets/js/pages/crud/forms/widgets/select2.js';
        $scripts[] = '../../js/zipcode.js';
        $scripts[] = '../../js/mask.js';


        $vehicle = $this->repository->findByField('id', $id)->first();

        $owners = $this->personRepository->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => 4]);

        if($vehicle)
        {
            return view('index', compact('cars', 'route', 'edit', 'links', 'scripts',
                'vehicle', 'brands', 'states', 'owners'));
        }

        abort(404);
    }

    /**
     * Store a new vehicle
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all(); //dd($data);

        $data['workshop_id'] = $this->get_user_workshop();

        try{
            if($data['car_id'])
            {
                $car = $this->repository->findByField('id', $data['car_id'])->first();

                if($car){
                    $this->repository->create($data);
                }


            }
            else{

                $data['car_id'] = $this->carRepository->create($data)->id;

                $this->repository->create($data);
            }

            DB::commit();

            $request->session()->flash('success.msg', 'Veículo cadastrado com sucesso');

            return redirect()->route('vehicle.index');

        }catch (\Exception $e)
        {
            DB::rollBack();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');
        }

        return redirect()->back()->withInput();

    }

    /**
     * Update a selected vehicle
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::beginTransaction();

        try{

            $this->repository->update($data, $id);

            DB::commit();

            $request->session()->flash('success.msg', 'Veículo alterado com sucesso');

            return redirect()->route('vehicle.index');

        }catch (\Exception $e)
        {
            DB::rollBack();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            return redirect()->back()->withInput();
        }
    }

    /**
     * Delete selected vehicle
     * @param $id
     */
    public function delete($id)
    {
        DB::beginTransaction();

        try{
            if($this->repository->findByField('id', $id)->first())
            {
                $this->repository->delete($id);

                DB::commit();

                return json_encode(['status' => true]);
            }
            else{

                return json_encode(['status' => false, 'msg' => 'Este veículo não existe']);
            }

        }catch (\Exception $e){
            DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }

    public function domains(Request $request, $length = null)
    {
        $file = fopen("https://registro.br/dominio/lista-processo-liberacao.txt", "r");
        //$file = fopen("teste.txt", "r");

        while(!feof($file))
        {

            $stop = false;

            $line = fgets($file);

            if(substr($line, 0, 1) !== "#")
            {
                $length = $length ? $length : 3;

                for ($i = 0; $i < $length; $i++)
                {
                    $char = substr($line, $i, 1);

                    if(is_numeric($char)) {
                        $stop = true;
                    }

                }

                if(!$stop)
                {
                    $point = substr($line, $length, 1);

                    if($point === "."){

                        $final = strstr($line, '.com.br');

                        if($final)
                            echo $line . "<br>";

                    }
                }
            }



        }

        fclose($file);
    }
}
