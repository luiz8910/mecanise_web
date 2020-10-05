<?php

namespace App\Http\Controllers;

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

class OrderController extends Controller
{
    use Config;

    /**
     * @var OrderRepository
     */
    private $repository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var CarRepository
     */
    private $carRepository;
    /**
     * @var VehicleRepository
     */
    private $vehicleRepository;
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
     * @var ConfigRepository
     */
    private $configRepository;

    public function __construct(OrderRepository $repository, PersonRepository $personRepository,
                                CarRepository $carRepository, VehicleRepository $vehicleRepository,
                                WorkshopRepository $workshopRepository, StatesRepository $statesRepository,
                                ColorsRepository $colorsRepository, ConfigRepository $configRepository)
    {

        $this->repository = $repository;
        $this->personRepository = $personRepository;
        $this->carRepository = $carRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->workshopRepository = $workshopRepository;
        $this->statesRepository = $statesRepository;
        $this->colorsRepository = $colorsRepository;
        $this->configRepository = $configRepository;
    }

    public function index($orderBy = null, $filter = null)
    {
        $route = 'orders.index';

        $scripts[] = '../../js/order.js';

        if($filter)
        {
            $today = date_create();

            if ($filter == "opened")
            {
                $orders = $this->repository->findWhere([
                    'workshop_id' => $this->get_user_workshop(),
                    'conclusion_at' => null
                ]);
            }
            elseif($filter == 'closed')
            {
                $orders = $this->repository->findWhere([
                    'workshop_id' => $this->get_user_workshop(),
                    ['conclusion_at', '<>', null]
                ]);
            }
            elseif ($filter == "this_week")
            {
                //Storing actual day without change variable $today
                $t = date_create();

                //Dia da semana / Week day number
                //1 for Monday, 7 for Sunday
                $w_today = date('N');

                //A way to find the previous monday
                date_add($t, date_interval_create_from_date_string('-'. $w_today. ' days'));

                //Gets tomorrow date
                date_add($today, date_interval_create_from_date_string('1 day'));

                //dd($today);

                $orders = DB::table('orders')
                    ->whereNull('deleted_at')
                    ->whereDate('conclusion_at', '>', date_format($t, 'Y-m-d') . ' 00:00:00')
                    ->whereDate('conclusion_at', '<', date_format($today, 'Y-m-d') . ' 00:00:00')
                    ->where(['workshop_id' => $this->get_user_workshop()])
                    ->get();

            }
            elseif($filter == "past_week")
            {
                //Storing actual day without change variable $today
                $t = date_create();

                //Dia da semana / Week day number
                //1 for Monday, 7 for Sunday
                $w_today = date('N');

                //A way to find the previous monday
                date_add($t, date_interval_create_from_date_string('-'. ($w_today * 2). ' days'));

                //Gets tomorrow date
                date_add($today, date_interval_create_from_date_string('1 day'));

                //dd($today);

                $orders = DB::table('orders')
                    ->whereNull('deleted_at')
                    ->whereDate('conclusion_at', '>', date_format($t, 'Y-m-d') . ' 00:00:00')
                    ->whereDate('conclusion_at', '<', date_format($today, 'Y-m-d') . ' 00:00:00')
                    ->where(['workshop_id' => $this->get_user_workshop()])
                    ->get();
            }
            elseif($filter == 'this_month')
            {
                $this_month = date('n');
                $year = date_format(date_create(), "Y");

                $orders = DB::table('orders')
                    ->where(['workshop_id' => $this->get_user_workshop()])
                    ->whereNull('deleted_at')
                    ->whereMonth('conclusion_at', $this_month)
                    ->whereYear('conclusion_at', $year)
                    ->get();

            }
            elseif($filter == 'past_month')
            {

                $this_month = date('n');

                //If this month is january, the past month is december of previous year
                if($this_month == 1)
                {
                    $past_month = '12';
                    $year = date('Y') - 1;
                }
                //Gets the previous month of the same year
                else{
                    $past_month = $this_month - 1;
                    $year = date('Y');
                }

                $orders = DB::table('orders')
                    ->where(['workshop_id' => $this->get_user_workshop()])
                    ->whereNull('deleted_at')
                    ->whereMonth('conclusion_at', $past_month)
                    ->whereYear('conclusion_at', $year)
                    ->get();
            }
            elseif ($filter == "deleted")
            {

                $orders = DB::table('orders')
                                ->where(['workshop_id' => $this->get_user_workshop()])
                                ->whereNotNull('deleted_at')
                                ->get();
            }

        }
        else
            $orders = $this->repository->findByField('workshop_id', $this->get_user_workshop());


        //dd($orders);

        foreach ($orders as $order)
        {
            $order->owner_name = $this->personRepository->findByField('id', $order->owner_id)->first();

            if($order->owner_name)
                $order->owner_name = $order->owner_name->name;

            else{
                $result = DB::table('people')->where('id', $order->owner_id)->first();

                if($result)
                    $order->owner_name = $result->name;

                else
                    $order->owner_name = "Cliente não informado";
            }

            $order->vehicle_name = $this->carRepository->findByField('id', $order->car_id)->first();

            if($order->vehicle_name)
                $order->vehicle_name = $order->vehicle_name->model;

            else{
                $result = DB::table('cars')->where('id', $order->car_id)->first();

                if($result)
                    $order->vehicle_name = $result->model;

                else
                    $order->vehicle_name = 'Veículo não informado';
            }

            $order->conclusion_at = $order->conclusion_at ?
                date_format(date_create($order->conclusion_at), 'd/m/Y') : 'Em Aberto';
        }

        $orderBy = $orderBy ? $orderBy : 'created_at';

        if($orderBy == 'created_at')
            $orders = $orders->sortByDesc($orderBy);

        else
            $orders = $orders->sortBy($orderBy);

        $qtde_model = count($this->repository->findByField('conclusion_at', null));

        $offset = $this->configRepository->findByField('key', 'pagination')->first() ?
            $this->configRepository->findByField('key', 'pagination')->first()->value : 10;

        return view('index', compact('route', 'orders', 'scripts', 'qtde_model', 'offset'));
    }


    public function create()
    {
        $route = 'orders.form';

        $edit = false;

        $scripts[] = '../../js/order.js';
        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../js/zipcode.js';
        $scripts[] = '../../js/mask.js';
        $scripts[] = '../../js/jquery.maskMoney.js';
        $scripts[] = '../../js/config.js';
        $scripts[] = '../../js/address.js';
        $scripts[] = '../../js/search.js';
        $links[] = '../../css/search.css';

        $people = $this->personRepository->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => 4]);

        $states = $this->statesRepository->orderBy('state')->all();

        $cars = $this->carRepository->all();

        $colors = $this->colorsRepository->all();

        $cars = $cars->sortBy('model');

        $people = $people->sortBy('name');

        $colors = $colors->sortBy('name');

        $vehicles = $this->vehicleRepository->findByField('workshop_id', $this->get_user_workshop());

        foreach ($vehicles as $vehicle)
        {
            $vehicle->name = $this->carRepository->findByField('id', $vehicle->car_id)->first() ?
                $this->carRepository->findByField('id', $vehicle->car_id)->first()->model : 'Veículo Desconhecido';
        }

        return view('index', compact('route', 'edit', 'scripts', 'people', 'states',
            'cars', 'colors', 'vehicles', 'links'));
    }

    public function edit($id)
    {
        $route = 'orders.form';

        $edit = true;

        $scripts[] = '../../js/order.js';
        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../js/zipcode.js';
        $scripts[] = '../../js/mask.js';
        $scripts[] = '../../js/jquery.maskMoney.js';
        $scripts[] = '../../js/config.js';
        $scripts[] = '../../js/address.js';
        $scripts[] = '../../js/search.js';
        $links[] = '../../css/search.css';

        $order = $this->repository->findByField('id', $id)->first();

        if($order)
        {
            $order->done_at = date_format(date_create($order->done_at), 'd/m/Y');
            $order->conclusion_at = date_format(date_create($order->conclusion_at), 'd/m/Y');
            $order->owner_name = $this->personRepository->findByField('id', $order->owner_id)->first() ?
                $this->personRepository->findByField('id', $order->owner_id)->first()->name
                : "Proprietário desconhecido";

            $owners = $this->personRepository->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => 4]);

            $states = $this->statesRepository->orderBy('state')->all();

            $cars = $this->carRepository->all();

            $cars = $cars->sortBy('model');

            $colors = $this->colorsRepository->all();

            $colors = $colors->sortBy('name');

            $vehicles = $this->vehicleRepository->findByField('owner_id', $order->owner_id);

            foreach ($vehicles as $vehicle) {
                $vehicle->name = $this->carRepository->findByField('id', $vehicle->car_id)->first()->model;
            }

            $people = $this->personRepository->findByField('workshop_id', $this->get_user_workshop());

            return view('index', compact('route', 'edit', 'scripts', 'owners',
                'states', 'cars', 'colors', 'vehicles', 'order', 'people', 'links'));
        }

        return abort(404);

    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $data = $request->all();

        //dd($data);

        try {

            $data['code'] = $this->random_number(5);

            if($this->repository->findByField('code', $data['code'])->first())
                $this->store($request);

            $data['workshop_id'] = $this->get_user_workshop();

            $data['done_at'] = str_replace('/', '-', $data['done_at']);
            $data['conclusion_at'] = $data['conclusion_at'] != "" ?
                str_replace('/', '-', $data['conclusion_at']) : null;

            $data['done_at'] = date_format(date_create($data['done_at']), 'Y-m-d');

            $data['conclusion_at'] = $data['conclusion_at'] ? date_format(date_create($data['conclusion_at']), 'Y-m-d') : null;

            //$v['owner_id'] = $data['owner_id'];

            //$this->vehicleRepository->update($v, $data['car_id']);

            if(!$data['car_id'] || !isset($data['car_id']))
            {
                $request->session()->flash('error.msg', 'Escolha um modelo válido');

                return isset($data['origin']) ? json_encode(['status' => false, 'msg' => 'Escolha um modelo válido']) :
                    redirect()->back();
            }
            else{
                $vehicle = $this->vehicleRepository->findByField('car_id', $data['car_id'])->first();

                if($vehicle)
                {
                    $data['vehicle_id'] = $vehicle->id;
                    $data['car_id'] = $vehicle->car_id;

                    $this->repository->create($data);

                    DB::commit();

                    $request->session()->flash('success.msg', 'A Ordem de Serviço nº ' .$data['code']. ' foi criada com sucesso');
                }
                else
                    $request->session()->flash('error.msg', 'Veículo não encontrado');

                return redirect()->route('order.index');
            }

        }catch (\Exception $e)
        {
            DB::rollBack();

            $error = $e->getMessage(); //'Um erro desconhecido aconteceu, tente novamente mais tarde';

            dd($e);
            $request->session()->flash('error.msg', $error);

            return isset($data['origin']) ? json_encode(['status' => false, 'msg' => $error]):redirect()->back();
        }

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        //dd($data);

        DB::beginTransaction();

        try {

            $data['workshop_id'] = $this->get_user_workshop();

            $data['done_at'] = str_replace('/', '-', $data['done_at']);
            $data['conclusion_at'] = $data['conclusion_at'] != "" ?
                str_replace('/', '-', $data['conclusion_at']) : null;

            $data['done_at'] = date_format(date_create($data['done_at']), 'Y-m-d');

            $data['conclusion_at'] = $data['conclusion_at'] ? date_format(date_create($data['conclusion_at']), 'Y-m-d') : null;

            //$v['owner_id'] = $data['owner_id'];

            //$this->vehicleRepository->update($v, $data['car_id']);

            if(!$data['car_id'])
            {
                $request->session()->flash('error.msg', 'Escolha um modelo válido');

                return isset($data['origin']) ? json_encode(['status' => false, 'msg' => 'Escolha um modelo válido']) :
                    redirect()->back();
            }
            else{

                $vehicle = $this->vehicleRepository->findByField('car_id', $data['car_id'])->first();

                if($vehicle)
                {
                    $data['vehicle_id'] = $vehicle->id;
                    $data['car_id'] = $vehicle->car_id;

                    $this->repository->update($data, $id);

                    $code = $this->repository->findByField('id', $id)->first()->code;

                    DB::commit();

                    $request->session()->flash('success.msg', 'A Ordem de Serviço nº '. $code. ' foi alterada com sucesso');
                }
                else
                    $request->session()->flash('error.msg', 'Veículo não encontrado');


                return redirect()->route('order.index');
            }

        }catch (\Exception $e)
        {
            DB::rollBack();

            $error = $e->getMessage(); //'Um erro desconhecido aconteceu, tente novamente mais tarde';

            $request->session()->flash('error.msg', $error);

            return isset($data['origin']) ? json_encode(['status' => false, 'msg' => $error]):redirect()->back();
        }
    }

    public function delete($id)
    {
        $order = $this->repository->findByField('id', $id)->first();

        DB::beginTransaction();

        try{
            if($order)
                $this->repository->delete($id);

            DB::commit();

            return json_encode(['status' => true]);
        }catch (\Exception $e){
            DB::rollBack();

            return json_encode(['status' => false, 'msg' => 'Um erro desconhecido ocorreu']);
        }

    }

    /*
     * Get vehicles for a owner
     */
    public function get_vehicles($owner_id)
    {
        $vehicles = $this->vehicleRepository->findByField('owner_id', $owner_id);

        if(count($vehicles) > 0)
        {
            foreach ($vehicles as $vehicle) {

                $vehicle->car_name = $this->carRepository->findByField('id', $vehicle->car_id)->first()->model;
            }

            return json_encode(['status' => true, 'vehicles' => count($vehicles) === 1 ? $vehicles[0] : $vehicles, 'count' => count($vehicles)]);
        }
        else
            return json_encode(['status' => false, 'msg' => 'Nenhum carro foi encontrado deste proprietário']);
    }
}





