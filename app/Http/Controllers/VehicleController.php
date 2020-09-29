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
    private $person;
    /**
     * @var CarRepository
     */
    private $car;
    /**
     * @var WorkshopRepository
     */
    private $workshop;
    /**
     * @var StatesRepository
     */
    private $states;
    /**
     * @var ColorsRepository
     */
    private $colors;
    /**
     * @var CarBrandsRepository
     */
    private $brands;
    /**
     * @var ConfigRepository
     */
    private $config;
    /**
     * @var OrderRepository
     */
    private $order;

    public function __construct(VehicleRepository $repository, PersonRepository $person,
                                CarRepository $car, WorkshopRepository $workshop,
                                StatesRepository $states, ColorsRepository $colors,
                                CarBrandsRepository $brands, ConfigRepository $config,
                                OrderRepository $order)
    {

        $this->repository = $repository;
        $this->person = $person;
        $this->car = $car;
        $this->workshop = $workshop;
        $this->states = $states;
        $this->colors = $colors;
        $this->brands = $brands;
        $this->config = $config;
        $this->order = $order;
    }

    /**
     * List all vehicle in workshop
     * @return View
     */
    public function index($orderBy = null)
    {
        $vehicles = $this->repository->findWhere([
            'workshop_id' => $this->get_user_workshop(),
            'active' => 1
        ]);

        $workshop = $this->workshop->findByField('id', $this->get_user_workshop())->first();

        $offset = $this->config->findByField('key', 'pagination')->first() ?
            $this->config->findByField('key', 'pagination')->first()->value : 10;

        if($workshop)
        {
            $scripts[] = '../../js/vehicle.js';

            $route = 'vehicles.index';

            foreach ($vehicles as $vehicle)
            {
                $car = $this->car->findByField('id', $vehicle->car_id)->first();

                if($car) {

                    $vehicle->model = $car->model;

                    $vehicle->owner_name = $this->person->findByField('id', $vehicle->owner_id)->first() ?
                        $this->person->findByField('id', $vehicle->owner_id)->first()->name : 'Veículo sem proprietário';

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
    public function create($person_id = null)
    {
        $cars =  $this->car->orderBy('model')->all();

        $brands = DB::table('cars')
                        ->whereNull('deleted_at')
                        ->select('brand')
                        ->distinct()
                        ->get();


        $route = 'vehicles.form';

        $edit = false;

        $people = $this->person->orderBy('name')->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => $this->get_owner_id()]);

        $states = $this->states->orderBy('state')->all();

        $colors = $this->colors->orderBy('name')->all();

        $owner = $person_id ? $this->person->findByField('id', $person_id)->first() : null;

        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../js/address.js';
        $scripts[] = '../../js/mask.js';
        $scripts[] = '../../js/search.js';
        $scripts[] = '../../js/config.js';
        $links[] = '../../css/search.css';

        return view('index', compact('cars', 'route', 'scripts',
            'edit', 'brands', 'states', 'people', 'colors', 'links', 'owner'));
    }

    /**
     * Edit selected vehicle
     * @param $id
     */
    public function edit($id)
    {
        $cars = $brands = $this->car->all();

        $route = 'vehicles.form';

        $edit = true;

        $states = $this->states->orderBy('state')->all();

        //$scripts[] = '../../assets/js/pages/custom/user/add-user.js';
        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../js/address.js';
        $scripts[] = '../../js/mask.js';
        $scripts[] = '../../js/search.js';
        $scripts[] = '../../js/config.js';
        $links[] = '../../css/search.css';

        $vehicle = $this->repository->findByField('id', $id)->first();

        $people = $this->person->orderBy('name')
            ->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => 4]);

        $colors = $this->colors->orderBy('name')->all();

        $car = $this->car->findByField('id', $vehicle->car_id)->first();

        for ($i = $car->start_year; $i < ($car->end_year + 1); $i++)
        {
            $years[] = $i;
        }

        if($vehicle)
        {
            $active = 1;

            if($vehicle->active == 0)
                $active = 0;

            $brand_id = $this->car->findByField('id', $vehicle->car_id)->first()->brand;

            $vehicle->brand_name = $this->brands->findByField('id', $brand_id)->first()->name;

            return view('index', compact('cars', 'route', 'edit', 'scripts',
                'vehicle', 'brands', 'states', 'people', 'colors', 'years', 'links', 'car', 'active'));
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

        //dd($data);

        $data['workshop_id'] = $this->get_user_workshop();

        DB::beginTransaction();

        try{
            if($data['car_id'])
            {
                $car = $this->car->findByField('id', $data['car_id'])->first();

                if($car)
                    $id = $this->repository->create($data)->id;
            }
            else{

                $data['car_id'] = $this->car->create($data)->id;

                $car = $this->car->findByField('id', $data['car_id'])->first();

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
                $x['active'] = 0;
                $this->repository->update($x, $id);

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

            $car->brand_name = $this->brands->findByField('id', $car->brand)->first() ?
                $this->brands->findByField('id', $car->brand)->first()->name : "Montadora não encontrada";

            $vehicles = $this->repository->findByField('car_id', $car->id);

            if(count($vehicles) > 0)
                foreach ($vehicles as $vehicle) {
                    $vehicle->owner_name = $this->person->findByField('id', $vehicle->owner_id)->first() ?
                        $this->person->findByField('id', $vehicle->owner_id)->first()->name : "Proprietário não encontrado";

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

    /*
     * Reactivate deleted vehicle
     * Reativa um veículo excluído
     */
    public function reactivate($id)
    {
        $model = $this->repository->findByField('id', $id)->first();

        if($model)
        {
            $x['active'] = 1;

            DB::beginTransaction();

            try{
                $this->repository->update($x, $id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e)
            {
                DB::rollBack();

                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }
        }

        return json_encode(['status' => false, 'msg' => 'Este veículo não existe']);
    }

    public function vehicle_by_owner($owner_id, $json = null)
    {
        $vehicles = $this->repository->findByField('owner_id', $owner_id);

        if(count($vehicles) > 0)
        {
            foreach ($vehicles as $vehicle)
            {
                $vehicle->name = $this->car->findByField('id', $vehicle->car_id)->first() ?
                    $this->car->findByField('id', $vehicle->car_id)->first()->model : 'Veículo desconhecido';
            }

            return json_encode(['status' => true, 'vehicles' => $vehicles]);
        }

        else
            return json_encode(['status' => false, 'msg' => 'Nenhum veículo foi encontrado']);

    }

}













