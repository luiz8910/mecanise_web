<?php

namespace App\Http\Controllers;

use App\Repositories\CarBrandsRepository;
use App\Repositories\CarRepository;
use App\Repositories\ColorsRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\OrderRepository;
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
    /**
     * @var CarBrandsRepository
     */
    private $brandsRepository;
    /**
     * @var ConfigRepository
     */
    private $config;
    /**
     * @var OrderRepository
     */
    private $order;

    public function __construct(VehicleRepository $repository, PersonRepository $personRepository,
                                CarRepository $carRepository, WorkshopRepository $workshopRepository,
                                StatesRepository $statesRepository, ColorsRepository $colorsRepository,
                                CarBrandsRepository $brandsRepository, ConfigRepository $config,
                                OrderRepository $order)
    {

        $this->repository = $repository;
        $this->personRepository = $personRepository;
        $this->carRepository = $carRepository;
        $this->workshopRepository = $workshopRepository;
        $this->statesRepository = $statesRepository;
        $this->colorsRepository = $colorsRepository;
        $this->brandsRepository = $brandsRepository;
        $this->config = $config;
        $this->order = $order;
    }

    /**
     * List all vehicle in workshop
     * @return View
     */
    public function index($orderBy = null)
    {
        $vehicles = $this->repository->findByField('workshop_id', $this->get_user_workshop());

        $workshop = $this->workshopRepository->findByField('id', $this->get_user_workshop())->first();

        $offset = $this->config->findByField('key', 'pagination')->first() ?
            $this->config->findByField('key', 'pagination')->first()->value : 10;

        if($workshop)
        {
            $scripts[] = '../../js/vehicle.js';

            $route = 'vehicles.index';

            foreach ($vehicles as $vehicle)
            {
                $car = $this->carRepository->findByField('id', $vehicle->car_id)->first();

                if($car) {

                    $vehicle->model = $car->model;

                    $vehicle->owner_name = $this->personRepository->findByField('id', $vehicle->owner_id)->first() ?
                        $this->personRepository->findByField('id', $vehicle->owner_id)->first()->name : 'Veículo sem proprietário';

                    $vehicle->last_job = $this->order->findByField('vehicle_id')->first() ?
                        date_format(date_create($this->order->findByField('vehicle_id')->first()->done_at), 'd/m/Y')
                        : 'Não consta OS para este veículo';
                }
            }

            $orderBy = $orderBy ? $orderBy : 'model';

            $vehicles = $vehicles->sortBy($orderBy);

            $qtde_model = count($vehicles);

            return view('index', compact('vehicles', 'route', 'scripts', 'offset', 'qtde_model'));
        }


    }


    /**
     * Create a new vehicle
     * @return View
     */
    public function create()
    {
        $cars =  $this->carRepository->orderBy('model')->all();

        $brands = DB::table('cars')
                        ->whereNull('deleted_at')
                        ->select('brand')
                        ->distinct()
                        ->get();


        $route = 'vehicles.form';

        $edit = false;

        $people = $this->personRepository->orderBy('name')->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => $this->get_owner_id()]);

        $states = $this->statesRepository->orderBy('state')->all();

        $colors = $this->colorsRepository->orderBy('name')->all();

        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../js/address.js';
        $scripts[] = '../../js/mask.js';
        $scripts[] = '../../js/search.js';
        $links[] = '../../css/search.css';

        return view('index', compact('cars', 'route', 'scripts',
            'edit', 'brands', 'states', 'people', 'colors', 'links'));
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

        //$scripts[] = '../../assets/js/pages/custom/user/add-user.js';
        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../js/address.js';
        $scripts[] = '../../js/mask.js';
        $scripts[] = '../../js/search.js';
        $links[] = '../../css/search.css';

        $vehicle = $this->repository->findByField('id', $id)->first();

        $owners = $this->personRepository->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => 4]);

        $colors = $this->colorsRepository->orderBy('name')->all();

        $car = $this->carRepository->findByField('id', $vehicle->car_id)->first();

        for ($i = $car->start_year; $i < ($car->end_year + 1); $i++)
        {
            $years[] = $i;
        }

        if($vehicle)
        {
            $brand_id = $this->carRepository->findByField('id', $vehicle->car_id)->first()->brand;

            $vehicle->brand_name = $this->brandsRepository->findByField('id', $brand_id)->first()->name;

            return view('index', compact('cars', 'route', 'edit', 'scripts',
                'vehicle', 'brands', 'states', 'owners', 'colors', 'years', 'links'));
        }

        return abort(404);
    }

    /**
     * Store a new vehicle
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        dd($data);

        $data['workshop_id'] = $this->get_user_workshop();

        DB::beginTransaction();

        try{
            if($data['car_id'])
            {
                $car = $this->carRepository->findByField('id', $data['car_id'])->first();

                if($car)
                    $id = $this->repository->create($data)->id;
            }
            else{

                $data['car_id'] = $this->carRepository->create($data)->id;

                $car = $this->carRepository->findByField('id', $data['car_id'])->first();

                $id = $this->repository->create($data)->id;
            }

            DB::commit();

            $request->session()->flash('success.msg', 'Veículo cadastrado com sucesso');

            return isset($data['origin']) ? json_encode(['status' => true, 'id' => $id, 'name' => $car->model]) : redirect()->route('vehicle.index');

        }catch (\Exception $e)
        {
            DB::rollBack();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');
        }

        return isset($data['origin']) ?
            json_encode(['status' => false, 'msg' => 'Um erro desconhecido ocorreu, tente novamente mais tarde'])
            : redirect()->back()->withInput();

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

    public function search($input)
    {
        $owners = DB::table('vehicles')
                    ->where([
                        'workshop_id' => $this->get_user_workshop(),
                        'deleted_at' => null

                    ])
                    ->select('car_id')
                    ->get();


        foreach ($owners as $owner) {
            $o[] = $owner->car_id;
        }


        $cars = DB::table('cars')
                        ->where([
                            ['model', 'like', $input."%"],
                            'deleted_at' => null
                        ])
                        //->whereIn('id', $o)
                        ->limit(10)
                        ->orderBy('model')
                        ->get();


        $result = [];

        //dd($cars);

        foreach ($cars as $car)
        {

            $car->brand_name = $this->brandsRepository->findByField('id', $car->brand)->first() ?
                $this->brandsRepository->findByField('id', $car->brand)->first()->name : "Montadora não encontrada";

            $vehicles = $this->repository->findByField('car_id', $car->id);

            if(count($vehicles) > 0)
                foreach ($vehicles as $vehicle) {
                    $vehicle->owner_name = $this->personRepository->findByField('id', $vehicle->owner_id)->first() ?
                        $this->personRepository->findByField('id', $vehicle->owner_id)->first()->name : "Proprietário não encontrado";

                    $car->vehicle = $vehicle;

                    $vehicle->brand_name = $car->brand_name;

                    $vehicle->model = $car->model;

                    $result[] = $vehicle;
                }

        }

        return json_encode(['status' => true, 'result' => $result]);

    }

    public function search_all($input)
    {
        $cars = DB::table('cars')
            ->where([
                ['model', 'like', $input."%"],
                'deleted_at' => null
            ])
            //->whereIn('id', $o)
            ->limit(10)
            ->orderBy('model')
            ->get();


        $result = [];

        //dd($cars);

        if(count($cars) > 0)
        {
            foreach ($cars as $car)
            {
                $result[] = $car;
            }

            return json_encode(['status' => true, 'result' => $result]);
        }


        return json_encode(['status' => false, 'result' => $result, 'count' => 0]);
    }


}
