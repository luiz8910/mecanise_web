<?php

namespace App\Http\Controllers;


use App\Imports\PartsImportNGK;
use App\Repositories\PartsBrandsRepository;
use App\Repositories\PartsNameRepository;
use App\Repositories\PartsRepository;
use App\Repositories\SystemRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller{

    /**
     * @var PartsRepository
     */
    private $parts;
    /**
     * @var PartsNameRepository
     */
    private $partsName;
    /**
     * @var PartsBrandsRepository
     */
    private $partsBrands;
    /**
     * @var SystemRepository
     */
    private $system;

    public function __construct(PartsRepository $parts, PartsNameRepository $partsName, PartsBrandsRepository $partsBrands,
                                SystemRepository $system)
    {

        $this->parts = $parts;
        $this->partsName = $partsName;
        $this->partsBrands = $partsBrands;
        $this->system = $system;
    }

    public function view()
    {
        $route = 'config.import';

        $edit = false;

        $parts = $this->partsName->orderBy('name')->all();

        $parts_brands = $this->partsBrands->all();

        $system = $this->system->all();

        $links[] = '../../css/import.css';

        $scripts[] = '../../js/import.js';

        return view('index', compact('route', 'edit', 'parts', 'parts_brands', 'system', 'links', 'scripts'));
    }

    public function receive(Request $request)
    {
        //dd($request->all());

        $request->file('file')->storeAs(
            'imports', '../public/imports/import.xlsx'
        );

        $args = $request->get('system_id');

        if($request->get('brand_parts_id') === "1")
        {
            Excel::import(new PartsImportNGK($args), 'public/imports/import.xlsx');
        }


    }
}
