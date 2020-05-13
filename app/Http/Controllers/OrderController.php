<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository;
use App\Repositories\ColorsRepository;
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

    public function __construct(OrderRepository $repository, PersonRepository $personRepository,
                                CarRepository $carRepository, VehicleRepository $vehicleRepository,
                                WorkshopRepository $workshopRepository, StatesRepository $statesRepository,
                                ColorsRepository $colorsRepository)
    {

        $this->repository = $repository;
        $this->personRepository = $personRepository;
        $this->carRepository = $carRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->workshopRepository = $workshopRepository;
        $this->statesRepository = $statesRepository;
        $this->colorsRepository = $colorsRepository;
    }

    public function index()
    {
        $orders = $this->repository->findByField('workshop_id', $this->get_user_workshop());



    }


    public function create()
    {
        $route = 'orders.form';

        $edit = false;

        $scripts[] = '../../js/order.js';
        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../js/zipcode.js';
        $scripts[] = '../../js/mask.js';

        $owners = $this->personRepository->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => 4]);

        $states = $this->statesRepository->orderBy('state')->all();

        $cars = $this->carRepository->all();

        $colors = $this->colorsRepository->all();

        $cars = $cars->sortBy('model');

        $owners = $owners->sortBy('name');

        $colors = $colors->sortBy('name');

        return view('index', compact('route', 'edit', 'scripts', 'owners', 'states', 'cars', 'colors'));
    }

    public function edit($id)
    {
        $route = 'orders.form';

        $edit = true;

        $scripts[] = '../../js/order.js';
        $scripts[] = '../../js/vehicle.js';
        $scripts[] = '../../js/zipcode.js';
        $scripts[] = '../../js/mask.js';

        $order = $this->repository->findByField('id', $id)->first();

        $owners = $this->personRepository->findWhere(['workshop_id' => $this->get_user_workshop(), 'role_id' => 4]);

        $states = $this->statesRepository->orderBy('state')->all();

        $cars = $this->carRepository->all();

        $cars = $cars->sortBy('model');

        $colors = $this->colorsRepository->all();

        $colors = $colors->sortBy('name');

        $vehicles = $this->vehicleRepository->findByField('owner_id', $order->owner_id)->first();

        foreach ($vehicles as $vehicle) {
            $vehicle->name = $this->carRepository->findByField('id', $vehicle->car_id)->first()->model;
        }

        return view('index', compact('route', 'edit', 'scripts', 'owners',
            'states', 'cars', 'colors', 'vehicles'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();dd($data);

            $data['code'] = $this->random_number(5);

            if($this->repository->findByField('code', $data['code'])->first())
                $this->store($request);

            $data['workshop_id'] = $this->get_user_workshop();

            $data['done_at'] = str_replace('/', '-', $data['done_at']);
            $data['conclusion_at'] = str_replace('/', '-', $data['conclusion_at']);

            $data['done_at'] = date_format(date_create($data['done_at']), 'Y-m-d');

            $data['conclusion_at'] = date_format(date_create($data['conclusion_at']), 'Y-m-d');

            $v['owner_id'] = $data['owner_id'];

            $this->vehicleRepository->update($v, $data['vehicle_id']);

            if(!$data['car_id'])
            {
                $request->session()->flash('error.msg', 'Escolha um modelo válido');

                return isset($data['origin']) ? json_encode(['status' => false, 'msg' => 'Escolha um modelo válido']) :
                    redirect()->back();
            }
            else{
                if($this->carRepository->findByField('id', $data['car_id'])->first())
                    $id = $this->repository->create($data)->id;

                DB::commit();

                $request->session()->flash('success.msg', 'A Ordem de Serviço foi criada com sucesso');

                return redirect()->back();
            }

        }catch (\Exception $e)
        {
            DB::rollBack();

            $error = $e->getMessage(); //'Um erro desconhecido aconteceu, tente novamente mais tarde';

            $request->session()->flash('error.msg', $error);

            return isset($data['origin']) ? json_encode(['status' => false, 'msg' => $error]):redirect()->back();
        }

    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {

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





