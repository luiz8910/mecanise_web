<?php

namespace App\Http\Controllers;

use App\Repositories\ChecklistRepository;
use App\Repositories\DiagnosisRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\WorkshopRepository;
use App\Traits\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    use Config;

    private $repository;
    private $diagnosisRepository;
    private $vehicleRepository;
    private $workshopRepository;

    public function __construct(ChecklistRepository $repository, DiagnosisRepository $diagnosisRepository,
                                VehicleRepository $vehicleRepository, WorkshopRepository $workshopRepository)
    {

        $this->repository = $repository;
        $this->diagnosisRepository = $diagnosisRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->workshopRepository = $workshopRepository;
    }

    /**
     * List all active diagnosis
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $checklist = $this->repository->findByField('workshop_id', $this->get_user_workshop());

        $route = 'checklist.index';

        $scripts[] = 'checklist.js';

        return view('index', compact('scripts', 'route', 'checklist'));
    }

    public function list_by_vehicle($vehicle_id)
    {
        $vehicle = $this->vehicleRepository->findByField('id', $vehicle_id)->first();

        if($vehicle)
        {
            $checklist = $this->repository->findByField('workshop_id', $vehicle_id);

            $route = 'checklist.list_by_vehicle';

            $scripts[] = 'checklist.js';

            return view('index', compact('scripts', 'route', 'checklist'));
        }
    }


    public function create()
    {
        $route = 'checklist.create';

        $scripts[] = 'checklist.js';

        return view('index', compact( 'route', 'scripts'));
    }

    public function edit($id)
    {
        $checklists = $this->repository->findByField('id', $id)->first();

        if($checklist)
        {
            $route = 'checklist.edit';

            $scripts[] = 'checklist.js';

            return view('index', compact('category', 'checklist', 'route', 'scripts'));
        }

        return redirect()->back()->withInput();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();

        try{

            $this->repository->create($data);

            DB::commit();

            $request->session()->flash('success.msg', 'O Checklist foi cadastrado com sucesso');

            return redirect()->route('diagnosis.index');

        }catch (\Exception $e){

            DB::rollBack();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::beginTransaction();

        if($this->repository->findByField('id', $id)->first())
        {
            try{

                $this->repository->update($data, $id);

                DB::commit();

                $request->session()->flash('success.msg', 'O Checklist foi alteraco com sucesso');

                return redirect()->route('diagnosis.index');

            }catch (\Exception $e){

                DB::rollBack();

                $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

                return redirect()->back()->withInput();
            }
        }

        $request->session()->flash('error.msg', 'Este Checklist não existe');

        return redirect()->back()->withInput();

    }

    public function delete($id)
    {
        $checklist = $this->repository->findByField('id', $id)->first();

        if($checklist)
        {
            DB::beginTransaction();

            try{

                $this->repository->delete($id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e)
            {
                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }

        }

        return json_encode(['status' => false, 'msg' => 'Este Checklist não existe']);


    }
}
