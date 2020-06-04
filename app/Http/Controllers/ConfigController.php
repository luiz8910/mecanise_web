<?php

namespace App\Http\Controllers;

use App\Repositories\ConfigRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{

    private $repository;

    public function __construct(ConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $route = 'config.index';

        $edit = false;

        $pagination = $this->repository->findByField('key', 'pagination')->first();

        $scripts[] = '../../js/config.js';

        if($pagination)
        {
            $pagination = $pagination->value;
            return view('index', compact('route', 'edit', 'pagination', 'scripts'));
        }

        return abort(404);
    }

    public function set_pagination(Request $request)
    {
        $data['value'] = $request->get('pagination');

        $id = $this->repository->findByField('key', 'pagination')->first() ?
            $this->repository->findByField('key', 'pagination')->first()->id : null;

        if($id)
        {
            DB::beginTransaction();

            try {
                $this->repository->update($data, $id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e){
                DB::rollBack();

                return json_encode(['status' => false]);
            }

        }

        return json_encode(['status' => false]);
    }
}
