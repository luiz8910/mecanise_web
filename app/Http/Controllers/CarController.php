<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Repositories\CarBrandsRepository;
use App\Repositories\CarRepository;
use App\Repositories\ConfigRepository;
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
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    public function __construct(CarRepository $repository, FuelRepository $fuelRepository, CarBrandsRepository $brandsRepository,
                                ConfigRepository $configRepository)
    {
        $this->repository = $repository;
        $this->fuelRepository = $fuelRepository;
        $this->brandsRepository = $brandsRepository;
        $this->configRepository = $configRepository;
    }

    /**
     * List all cars
     */
    public function index()
    {
        $offset = $this->configRepository->findByField('key', 'pagination')->first() ?
            $this->configRepository->findByField('key', 'pagination')->first()->value : 10;

        $cars = $this->repository->orderBy('model')->paginate($offset);

        $qtde_model = count($this->repository->all());

        $route = 'cars.index';

        $edit = false;

        $scripts[] = '../../js/car.js';


        foreach ($cars as $car){

            $car->brand_name = $this->brandsRepository->findByField('id', $item->brand)->first() ?
                $this->brandsRepository->findByField('id', $item->brand)->first()->name : 'Nâo informado';

            $car->fuel_name = $this->fuelRepository->findByField('id', $car->fuel)->first() ?
                $this->fuelRepository->findByField('id', $car->fuel)->first()->name : 'Não informado';
        }

        return view('index', compact('cars', 'route', 'scripts', 'edit', 'qtde_model', 'offset'));
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

    //Car Pagination Button
    public function car_pagination($offset)
    {
        $limit = $this->configRepository->findByField('key', 'pagination')->first() ?
            $this->configRepository->findByField('key', 'pagination')->first()->value : 10;

        $cars = DB::table('cars')
                ->orderBy('model')
                ->offset($offset)
                ->limit($limit)
                ->whereNull('deleted_at')
                ->get();

        for ($i = 0; $i < count($cars); $i++)
        {
            $cars[$i]->brand_name = $this->brandsRepository->findByField('id', $item->brand)->first() ?
                $this->brandsRepository->findByField('id', $item->brand)->first()->name : 'Nâo informado';

            $cars[$i]->fuel_name = $this->fuelRepository->findByField('id', $car->fuel)->first() ?
                $this->fuelRepository->findByField('id', $cars[$i]->fuel)->first()->name : 'Não informado';
        }

        return json_encode(['status' => true, 'cars' => $cars, 'edit' => '/editar_carro/', 'offset' => $offset + $limit]);
    }

    public function car_search($input)
    {
        $cars = DB::table('cars')
                    ->where('model', 'like', '%'.$input.'%')
                    ->whereNull('deleted_at')
                    ->limit(20)
                    ->get();

        $model = [];
        $i = 0;

        foreach ($cars as $item)
        {
            $model[$i]['column_0'] = $item->id;
            $model[$i]['column_1'] = $item->model;

            $model[$i]['column_2'] = $this->brandsRepository->findByField('id', $item->brand)->first() ?
                $this->brandsRepository->findByField('id', $item->brand)->first()->name : 'Nâo informado';

            $model[$i]['column_3'] = $this->fuelRepository->findByField('id', $car->fuel)->first() ?
                $this->fuelRepository->findByField('id', $item->fuel)->first()->name : 'Não informado';

            $model[$i]['column_4'] = $item->start_year ? $item->start_year : '';

            $model[$i]['column_5'] = $item->end_year ? $item->end_year : '';

            $i++;
        }

        return json_encode(['status' => true, 'model' => $model, 'columns' => 6, 'edit' => '/editar_carro/']);
    }

    //List all brands / Lista de todas as montadoras
    public function brands()
    {
        $offset = $this->configRepository->findByField('key', 'pagination')->first() ?
            $this->configRepository->findByField('key', 'pagination')->first()->value : 10;

        $brands = $this->brandsRepository->orderBy('name')->paginate($offset);

        $scripts[] = '../../js/car.js';

        $route = 'cars.brands';

        foreach ($brands as $brand)
        {
            $brand->qtde = count($this->repository->findByField('brand', $brand->id));
        }

        $qtde_model = count($this->brandsRepository->all());

        return view('index', compact('brands', 'scripts', 'route', 'qtde_model', 'offset'));
    }

    //Brand button pagination
    public function brand_pagination($offset)
    {
        $limit = $this->configRepository->findByField('key', 'pagination')->first() ?
            $this->configRepository->findByField('key', 'pagination')->first()->value : 10;

        $model = DB::table('car_brands')
            ->orderBy('name')
            ->offset($offset)
            ->limit($limit)
            ->get();

        foreach ($model as $item)
        {
            $item->qtde = count($this->repository->findByField('brand', $item->id));
        }

        return json_encode(['status' => true, 'model' => $model, 'offset' => $offset + $limit]);
    }

    //Verify if the brand name is available
    public function brand_exists($name)
    {
        $brand = $this->brandsRepository->findByField('name', $name)->first();

        if ($brand)
            return json_encode(['status' => false, 'msg' => 'Esta montadora já existe']);

        return json_encode(['status' => true]);
    }

    //Store a new car brand / Nova montadora
    public function brand_store(Request $request)
    {
        DB::beginTransaction();

        try{
            $data = $request->all();

            $this->brandsRepository->create($data);

            DB::commit();

            return json_encode(['status' => true]);
        }catch (\Exception $e){
            DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

    //Update a existing car brand / Alterar montadora
    public function brand_update(Request $request, $id)
    {
        DB::beginTransaction();

        $brand = $this->brandsRepository->findByField('id', $id)->first();

        if($brand)
        {
            try {
                $data = $request->all();

                $this->brandsRepository->update($data, $id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e) {

                DB::rollBack();

                return json_encode(['status' => false, 'msg' => '']);
            }
        }
        else
            return json_encode(['status' => false, 'msg' => 'Esta montadora não existe']);
    }

    //Searches in table car_brands
    public function brand_search($input)
    {
        $brands = DB::table('car_brands')
            ->where('model', 'like', '%'.$input.'%')
            ->limit(20)
            ->get();

        $model = [];
        $i = 0;

        foreach ($brands as $brand)
        {
            $model[$i]['id'] = $brand->id;
            $model[$i]['name'] = $brand->name;
            $model[$i]['qtde'] = count($this->repository->findByField('brand', $brand->id));

            $i++;
        }

        return json_encode(['status' => true, 'model' => $model]);
    }
}
