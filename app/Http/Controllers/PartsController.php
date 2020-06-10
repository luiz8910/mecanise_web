<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository;
use App\Repositories\PartsBrandsRepository;
use App\Repositories\PartsNameRepository;
use App\Repositories\PartsRepository;
use App\Repositories\SystemRepository;
use Illuminate\Http\Request;

class PartsController extends Controller
{

    private $repository;

    private $partsBrands;

    private $partsName;

    private $system;

    private $car;

    public function __construct(PartsRepository $repository, PartsBrandsRepository $partsBrands,
                                PartsNameRepository $partsName, SystemRepository $system, CarRepository $car)
    {

        $this->repository = $repository;
        $this->partsBrands = $partsBrands;
        $this->partsName = $partsName;
        $this->system = $system;
        $this->car = $car;
    }

    public function index()
    {

    }

    public function create()
    {
        $cars = $this->car->orderBy('model')->all();

        $parts_brands = $this->partsBrands->orderBy('name')->all();

        $system = $this->system->orderBy('name')->all();

        $parts_name = $this->partsName->orderBy('name')->all();

        $edit = false;

        $route = 'parts.form';

        return view('index', compact('cars', 'parts_brands', 'parts_name', 'system', 'edit', 'route'));
    }

    public function edit($id)
    {

    }
}
