<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;
use App\Repositories\WorkshopRepository;
use App\Traits\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    use Config;


    private $repository;
    private $workshopRepository;

    public function __construct(ServiceRepository $repository, WorkshopRepository $workshopRepository)
    {

        $this->repository = $repository;
        $this->workshopRepository = $workshopRepository;
    }

    /**
     * List all active services the workshop have
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $services = $this->repository->findByField('workshop_id', $this->get_user_workshop());

        $route = 'services.index';

        $scripts[] = 'service.js';

        return view('index', compact('scripts', 'route', 'services'));
    }


    public function create()
    {
        $route = 'services.create';

        $scripts[] = 'service.js';

        return view('index', compact( 'route', 'scripts'));
    }

    public function edit($id)
    {
        $service = $this->repository->findByField('id', $id)->first();

        if($service)
        {
            $route = 'services.edit';

            $scripts[] = 'service.js';

            return view('index', compact('category', 'service', 'route', 'scripts'));
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

            $request->session()->flash('success.msg', 'O serviço foi cadastrado com sucesso');

            return redirect()->route('services.index');

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

                $request->session()->flash('success.msg', 'O serviço foi alteraco com sucesso');

                return redirect()->route('services.index');

            }catch (\Exception $e){

                DB::rollBack();

                $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

                return redirect()->back()->withInput();
            }
        }

        $request->session()->flash('error.msg', 'Este produto não existe');

        return redirect()->back()->withInput();

    }

    public function delete($id)
    {
        $service = $this->repository->findByField('id', $id)->first();

        if($service)
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

        return json_encode(['status' => false, 'msg' => 'Este serviço não existe']);


    }
}
