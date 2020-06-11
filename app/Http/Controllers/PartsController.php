<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\PartsBrandsRepository;
use App\Repositories\PartsNameRepository;
use App\Repositories\PartsRepository;
use App\Repositories\SystemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartsController extends Controller
{

    private $repository;

    private $partsBrands;

    private $partsName;

    private $system;

    private $car;
    /**
     * @var ConfigRepository
     */
    private $config;

    public function __construct(PartsRepository $repository, PartsBrandsRepository $partsBrands,
                                PartsNameRepository $partsName, SystemRepository $system, CarRepository $car,
                                ConfigRepository $config)
    {

        $this->repository = $repository;
        $this->partsBrands = $partsBrands;
        $this->partsName = $partsName;
        $this->system = $system;
        $this->car = $car;
        $this->config = $config;
    }

    public function index($orderBy = null)
    {
        $offset = $this->config->findByField('key', 'pagination')->first() ?
            $this->config->findByField('key', 'pagination')->first()->value : 10;

        $route = 'parts.index';

        $scripts[] = '../../js/parts.js';

        $parts = $this->repository->all();

        foreach ($parts as $part)
        {
            $part->name = $this->partsName->findByField('id', $part->part_id)->first()
                        ? $this->partsName->findByField('id', $part->part_id)->first()->name
                        : 'Nome da Peça não encontrado';

            $part->model = $this->car->findByField('id', $part->car_id)->first()
                         ? $this->car->findByField('id', $part->car_id)->first()->model
                         : 'Carro não encontrado';

            $part->brand_name = $this->partsBrands->findByField('id', $part->brand_parts_id)->first()
                              ? $this->partsBrands->findByField('id', $part->brand_parts_id)->first()->name
                              : 'Marca não encontrada';

            $part->system_name = $this->system->findByField('id', $part->system_id)->first()
                               ? $this->system->findByField('id', $part->system_id)->first()->name
                               : 'Sistema não encontrado';
        }

        $qtde_model = count($parts);

        if($orderBy)
            $parts = $parts->sortBy($orderBy);
        else
            $parts = $parts->sortBy('name');


        return view('index', compact('route', 'scripts', 'parts', 'qtde_model', 'offset'));
    }

    public function create()
    {
        $cars = $this->car->orderBy('model')->all();

        $parts_brands = $this->partsBrands->orderBy('name')->all();

        $system = $this->system->orderBy('name')->all();

        $parts_name = $this->partsName->orderBy('name')->all();

        $edit = false;

        $route = 'parts.form';

        $scripts[] = '../../js/parts.js';

        return view('index', compact('cars', 'parts_brands', 'parts_name',
            'system', 'edit', 'route', 'scripts'));
    }

    public function edit($id)
    {
        $part = $this->repository->findByField('id', $id)->first();

        if($part)
        {
            $cars = $this->car->orderBy('model')->all();

            $parts_brands = $this->partsBrands->orderBy('name')->all();

            $system = $this->system->orderBy('name')->all();

            $parts_name = $this->partsName->orderBy('name')->all();

            $edit = true;

            $route = 'parts.form';

            $scripts[] = '../../js/parts.js';

            return view('index', compact('cars', 'parts_brands', 'parts_name',
                'system', 'edit', 'route', 'scripts', 'part'));
        }

        return abort(404);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();

        try{

            $this->repository->create($data);

            DB::commit();

            $request->session()->flash('success.msg', 'A peça foi cadastrada com sucesso');

            return redirect()->back();

        }catch (\Exception $e)
        {
            DB::rollBack();

            $request->session()->flash('error.msg', $e->getMessage());

            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::beginTransaction();

        try{

            $this->repository->update($data, $id);

            DB::commit();

            $request->session()->flash('success.msg', 'A peça foi alterada com sucesso');

            return redirect()->back();

        }catch (\Exception $e)
        {
            DB::rollBack();

            $request->session()->flash('error.msg', $e->getMessage());

            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $part = $this->repository->findByField('id', $id)->first();

        if($part)
        {
            DB::beginTransaction();

            try{

                $this->repository->delete($id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e){
                DB::rollBack();

                return json_encode(['status' => false, 'msg' => '']);
            }
        }

        return json_encode(['status' => false, 'msg' => 'Esta peça não existe']);
    }

    public function system_parts($system_id)
    {
        $system = $this->system->findByField('id', $system_id)->first();

        if($system)
        {
            $parts = $this->partsName->findByField('system_id', $system_id);

            return json_encode(['status' => true, 'parts' => $parts]);
        }

        return json_encode(['status' => false]);
    }
}
