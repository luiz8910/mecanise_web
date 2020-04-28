<?php

namespace App\Http\Controllers;

use App\Repositories\DiagnosisRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosisController extends Controller
{
    /**
     * @var DiagnosisRepository
     */
    private $repository;

    public function __construct(DiagnosisRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * List all active diagnosis
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $diagnosis = $this->repository->all();

        $route = 'diagnosis.index';

        $scripts[] = 'diagnosis.js';

        return view('index', compact('scripts', 'route', 'diagnosis'));
    }


    public function create()
    {
        $route = 'diagnosis.create';

        $scripts[] = 'diagnosis.js';

        return view('index', compact( 'route', 'scripts'));
    }

    public function edit($id)
    {
        $diagnosis = $this->repository->findByField('id', $id)->first();

        if($diagnosis)
        {
            $route = 'diagnosis.edit';

            $scripts[] = 'diagnosis.js';

            return view('index', compact('category', 'diagnosis', 'route', 'scripts'));
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

            $request->session()->flash('success.msg', 'O Diagnóstico foi cadastrado com sucesso');

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

                $request->session()->flash('success.msg', 'O Diagnóstico foi alteraco com sucesso');

                return redirect()->route('diagnosis.index');

            }catch (\Exception $e){

                DB::rollBack();

                $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

                return redirect()->back()->withInput();
            }
        }

        $request->session()->flash('error.msg', 'Este Diagnóstico não existe');

        return redirect()->back()->withInput();

    }

    public function delete($id)
    {
        $diagnosis = $this->repository->findByField('id', $id)->first();

        if($diagnosis)
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

        return json_encode(['status' => false, 'msg' => 'Este Diagnóstico não existe']);


    }
}
