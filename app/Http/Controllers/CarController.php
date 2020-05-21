<?php

namespace App\Http\Controllers;

use App\Repositories\CarBrandsRepository;
use App\Repositories\CarRepository;
use App\Repositories\FuelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    /**
     * @var CarRepository
     */
    private $repository;
    /**
     * @var FuelRepository
     */
    private $fuelRepository;
    /**
     * @var CarBrandsRepository
     */
    private $brandsRepository;

    public function __construct(CarRepository $repository, FuelRepository $fuelRepository, CarBrandsRepository $brandsRepository)
    {
        $this->repository = $repository;
        $this->fuelRepository = $fuelRepository;
        $this->brandsRepository = $brandsRepository;
    }

    /**
     * List all cars
     */
    public function index()
    {
        $cars = $this->repository->orderBy('model')->all();

        //dd($cars);
        $route = 'cars.index';

        $edit = false;

        $scripts[] = '../../js/car.js';
        $links[] = '../../css/main.css';

        foreach ($cars as $car){
            $car->brand_name = $this->brandsRepository->findByField('id', $car->brand)->first()->name;
        }

        return view('index', compact('cars', 'route', 'scripts', 'edit'));
    }

    /**
     * Create a new car
     */
    public function create()
    {
        $route = 'cars.form';

        $edit = false;

        $scripts[] = '../../js/car.js';

        $fuels = $this->fuelRepository->all();

        $brands = $this->brandsRepository->orderBy('name')->all();

        return view('index', compact('route', 'edit', 'scripts', 'fuels', 'brands'));
    }

    /**
     * Edit a car
     * @param $id
     */
    public function edit($id)
    {
        $car = $this->repository->findByField('id', $id)->first();

        $route = 'cars.form';

        $edit = true;

        $scripts[] = '../../js/car.js';

        if($car)
        {
            $fuels = $this->fuelRepository->all();

            $brands = $this->brandsRepository->orderBy('name')->all();

            return view('index', compact( 'route', 'edit', 'scripts', 'car', 'fuels', 'brands'));
        }

        abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();

        try{

            $data['model'] = strtoupper($data['model']);
            $data['brand'] = strtoupper($data['brand']);
            $data['version'] = strtoupper($data['version']);

            $this->repository->create($data);

            DB::commit();

            $request->session()->flash('success.msg', 'O carro foi cadastrado com sucesso');

            return redirect()->route('cars.index');

        }catch (\Exception $e){

            DB::rollBack();

            $request->session()->flash('error.msg', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::beginTransaction();

        try{

            $data['model'] = strtoupper($data['model']);
            $data['brand'] = strtoupper($data['brand']);
            $data['version'] = strtoupper($data['version']);

            $this->repository->update($data, $id);

            DB::commit();

            $request->session()->flash('success.msg', 'O carro foi alterado com sucesso');

            return redirect()->route('cars.index');

        }catch (\Exception $e){

            DB::rollBack();

            $request->session()->flash('error.msg', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

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

            return json_encode(['status' => false, 'msg' => 'Este carro não existe']);

        }catch (\Exception $e){

            DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }

    public function car_exists($model, $id = null)
    {

        $car = $this->repository->findByField('model', strtoupper($model))->first();

        if($car)
        {
            if($id)
            {
                if($car->id == $id)
                {
                    return json_encode(['status' => true, 'id' => true]);
                }
            }

            return json_encode(['status' => false, 'msg' => 'Erro! Este carro já está cadastrado']);
        }

        return json_encode(['status' => true]);


    }

    //Function called in vehicle.js
    public function car_details($id)
    {
        $car = $this->repository->findByField('id', $id)->first();

        if($car)
        {
            $car->brand = $this->brandsRepository->findByField('id', $car->brand)->first()->name;

            return json_encode(['status' => true, 'car' => $car]);
        }

        return json_encode(['status' => false, 'msg' => 'Este modelo não foi encontrado']);
    }
}
