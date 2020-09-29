<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RolesRepository;
use App\Repositories\StatesRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\WorkshopRepository;
use App\Traits\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PersonController extends Controller
{
    use Config;

    /**
     * @var PersonRepository
     */
    private $repository;
    /**
     * @var WorkshopRepository
     */
    private $workshops;
    /**
     * @var RolesRepository
     */
    private $roles;
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var StatesRepository
     */
    private $states;
    /**
     * @var ConfigRepository
     */
    private $config;
    /**
     * @var VehicleRepository
     */
    private $vehicles;
    /**
     * @var CarRepository
     */
    private $cars;
    /**
     * @var OrderRepository
     */
    private $orders;

    public function __construct(PersonRepository $repository, UserRepository $users,
                                WorkshopRepository $workshops, RolesRepository $roles,
                                StatesRepository $states, ConfigRepository $config, VehicleRepository $vehicles,
                                CarRepository $cars, OrderRepository $orders)
    {

        $this->repository = $repository;
        $this->workshops = $workshops;
        $this->roles = $roles;
        $this->users = $users;
        $this->states = $states;
        $this->config = $config;
        $this->vehicles = $vehicles;
        $this->cars = $cars;
        $this->orders = $orders;
    }

    public function index($orderBy = null, $role = null)
    {
        $workshop = $this->workshops->findByField('id', $this->get_user_workshop())->first();

        $offset = $this->config->findByField('key', 'pagination')->first() ?
            $this->config->findByField('key', 'pagination')->first()->value : 10;

        if($workshop)
        {
            if($orderBy)
            {
                $people = $this->repository->findWhere([
                    'workshop_id' => $this->get_user_workshop(),
                    'role_id' => $this->get_owner_id(),
                    'active' => 1
                ])->sortByDesc($orderBy);
            }
            else{
                $people = $this->repository->findWhere([
                    'workshop_id' => $this->get_user_workshop(),
                    'role_id' => $this->get_owner_id(),
                    'active' => 1
                ]);
            }


            $route = 'people.index';

            foreach ($people as $person)
            {
                $vehicle = $this->vehicles->findByField('owner_id', $person->id)->first();

                if($vehicle) {
                    $person->vehicle_name = $this->cars->findByField('id', $vehicle->car_id)->first() ?
                        $this->cars->findByField('id', $vehicle->car_id)->first()->model : 'Veículo não encontrado';

                    $person->vehicle_id = $vehicle->id;
                }
                else
                    $person->vehicle_name = 'Nenhum Veículo Cadastrado';



                /*$person->initials = $this->initials($person->name);

                $person->role_name = $this->roles->findByField('id', $person->role_id)->first() ?
                    $this->roles->findByField('id', $person->role_id)->first()->name : 'Cargo não definido';


                //$person->created_at_str = date_format(date_create($person->created_at), 'd/m/Y');*/
            }

            $qtde_model = count($people);

            $scripts[] = '../../js/person.js';

            return view('index', compact('route', 'people', 'qtde_model', 'offset', 'scripts'));
        }

        return abort(404);

    }

    public function index_table()
    {
        $scripts[] = 'assets/js/pages/crud/metronic-datatable/base/html-table.js';

        $workshop = $this->workshops->findByField('id', $this->get_user_workshop())->first();

        if($workshop)
        {
            $people = $workshop->people;
        }

        $route = 'people.list-table';

        foreach ($people as $person)
        {
            $person->initials = $this->initials($person->name);

            $person->role_name = $this->roles->findByField('id', $person->role_id)->first() ?
                $this->roles->findByField('id', $person->role_id)->first()->name : 'Cargo não definido';

            $person->created_at_str = date_format(date_create($person->created_at), 'd/m/Y');
        }

        $people_qtde = count($people);

        return view('index', compact('route', 'people', 'people_qtde', 'scripts'));
    }

    public function employees()
    {
        $workshop = $this->workshops->findByField('id', $this->get_user_workshop())->first();

        if($workshop)
            $people = $this->repository->findByField('role_id', 2);


        return $people;
        //TODO: return view
    }

    public function create($role = null)
    {

        //$scripts[] = '../../assets/js/pages/custom/user/add-user.js';
        $scripts[] = '../../js/person.js';
        $scripts[] = '../../js/address.js';
        $scripts[] = '../../js/config.js';
        $scripts[] = '../../js/mask.js';
        $links[] = '';

        $route = 'people.form';

        $roles = $this->roles->all();

        $states = $this->states->all();

        $edit = false;

        $role = $role ? $role : $this->get_owner_id();

        return view('index', compact( 'links', 'route', 'roles', 'scripts', 'states', 'edit', 'role'));
    }

    //$id = person id
    public function edit($id, $role = null)
    {
        $person = $this->repository->findByField('id', $id)->first();

        if($person->active == 0)
            $active = 0;

        if($person)
        {

            //$scripts[] = '../../assets/js/pages/custom/user/add-user.js';
            $scripts[] = '../../js/person.js';
            $scripts[] = '../../js/address.js';
            $scripts[] = '../../js/config.js';
            $scripts[] = '../../js/mask.js';
            $links[] = '';

            $route = 'people.form';

            $roles = $this->roles->all();

            $states = $this->states->all();

            $edit = true;

            $role = $role ? $role : $this->get_owner_id();

            return view('index', compact('links', 'route', 'person', 'roles',
                'scripts', 'states', 'edit', 'role', 'active'));
        }

        Session::flash('error.msg', 'Usuário não existe');

        return redirect()->route('home.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        //dd($data);
        $data['workshop_id'] = $this->get_user_workshop();

        $person = $this->repository->findByField('cpf', $data['cpf'])->first();

        DB::beginTransaction();

        try{

            if($data['role_id'] == $this->get_owner_id())
            {
                if($person)
                {
                    if(isset($data['dateBirth']))
                        $data['dateBirth'] = date_format(date_create($data['dateBirth']), 'Y-m-d');

                    $this->repository->update($data, $person->id);

                    DB::commit();

                    $request->session()->flash('success.msg', 'O usuário foi cadastrado com sucesso');

                    return isset($data['origin']) ? json_encode(['status' => true, 'id' => $person->id]) : redirect()->route('person.index');
                }
                else{
                    $id = $this->repository->create($data)->id;

                    DB::commit();

                    $request->session()->flash('success.msg', 'O usuário foi cadastrado com sucesso');

                    return isset($data['origin']) ? json_encode(['status' => true, 'id' => $id]) : redirect()->route('person.index');

                }
            }
            elseif($data['role_id'] == $this->get_operator_id())
            {
                if ($this->repository->findByField('email', $data['email'])->first()) {
                    $request->session()->flash('error.msg', 'O usuário já existe na base de dados');

                    return isset($data['origin']) ? json_encode(['status' => false, 'msg' => 'O usuário já existe na base de dados']) :
                        redirect()->back();
                }
                else{

                    if(isset($data['dateBirth']))
                        $data['dateBirth'] = date_format(date_create($data['dateBirth']), 'Y-m-d');


                    $person_id = $this->repository->create($data)->id;


                    $u['email'] = $data['email'];
                    $u['password'] = bcrypt($this->random_number());
                    $u['person_id'] = $person_id;
                    $u['workshop_id'] = $this->get_user_workshop();

                    $this->users->create($u);

                    DB::commit();

                    $request->session()->flash('success.msg', 'O usuário foi cadastrado com sucesso');

                    return isset($data['origin']) ? json_encode(['status' => true, 'id' => $person_id]) : redirect()->route('person.index');

                }
            }
        }catch (\Exception $e){
            DB::rollBack();

            $request->session()->flash('error.msg', $e->getMessage());

            return isset($data['origin']) ? json_encode(['status' => false, 'msg' => 'Um erro desconhecido ocorreu']) :
                redirect()->back();
        }

    }

    public function store_old(Request $request)
    {
        $data = $request->all();

        $data['workshop_id'] = $this->get_user_workshop();

        $user = $data['email'] != "" ? $this->users->findByField('email', $data['email'])->first() : false;

        if(!$user){
            $person = $this->repository->findByField('cpf', $data['cpf'])->first();

            if($person)
                $user = $person->user;
        }

        if($data['role_id'] == $this->get_owner_id())
        {
            if($user)
            {
                if($user->person->workshop_id != $this->get_user_workshop())
                {
                    $p['workshop_id'] = $this->get_user_workshop();

                    $this->repository->update($p, $user->person->id);

                    $request->session()->flash('success.msg', 'O usuário foi cadastrado com sucesso');

                    return isset($data['origin']) ? json_encode(['status' => true]) : redirect()->route('person.index');
                }
                else{

                    $request->session()->flash('error.msg', 'O usuário já existe na base de dados');

                    return isset($data['origin']) ? json_encode(['status' => false, 'msg' => 'O usuário já existe na base de dados']) :
                        redirect()->back();
                }
            }

        }
        elseif($data['role_id'] == $this->get_operator_id())
        {
            if ($user) {
                $request->session()->flash('error.msg', 'O usuário já existe na base de dados');

                return isset($data['origin']) ? json_encode(['status' => false, 'msg' => 'O usuário já existe na base de dados']) :
                    redirect()->back();
            }
        }

        DB::beginTransaction();

        try{

            if(isset($data['dateBirth']))
                $data['dateBirth'] = date_format(date_create($data['dateBirth']), 'Y-m-d');


            $person_id = $this->repository->create($data)->id;


            $u['email'] = $data['email'];
            $u['password'] = bcrypt($this->random_number());
            $u['person_id'] = $person_id;
            $u['workshop_id'] = $this->get_user_workshop();

            $this->users->create($u);

            DB::commit();

            $request->session()->flash('success.msg', 'O usuário foi cadastrado com sucesso');

            return isset($data['origin']) ? json_encode(['status' => true, 'id' => $person_id]) : redirect()->route('person.index');

        }catch (\Exception $e)
        {
            DB::rollBack();

            return isset($data['origin']) ? json_encode(['status' => false, 'msg' => $e->getMessage()]) : redirect()->route('person.index');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();



        $person = $this->repository->findByField('id', $id)->first();

        //User exists
        if($person)
        {
            if($person->email != $data['email'])
            {
                $email_exists = $this->repository->findByField('email', $data['email'])->first();

                //Email already in use
                if($email_exists)
                {
                    //Return message informing the error
                    $request->session()->flash('error.msg', 'Este email está sendo usado por outra pessoa, tente outro email.');
                    return redirect()->back()->withInput();
                }
                else{
                    //Workshop exists
                    if($this->workshops->findByField('email', $data['email'])->first())
                    {
                        //Return message informing the error
                        $request->session()->flash('error.msg', 'Este email está sendo usado por outra pessoa, tente outro email.');
                        return redirect()->back()->withInput();
                    }
                    //In case the new email is not in use, it changes email for login
                    else{
                        $user = $this->users->findByField('email', $person->email)->first();

                        if($user)
                            $this->users->update($data['email'], $user->id);

                    }
                }

            }

            DB::beginTransaction();

            try{

                if(isset($data['dateBirth']))
                    $data['dateBirth'] = date_format(date_create($data['dateBirth']), 'Y-m-d');


                $this->repository->update($data, $id);

                DB::commit();

                $request->session()->flash('success.msg', 'O usuário foi alterado com sucesso');

                return redirect()->route('person.index');

            }catch (\Exception $e)
            {
                DB::rollBack();

                $request->session()->flash('error.msg', $e->getMessage());

                return redirect()->back()->withInput();
            }
        }

        //User doesn't exists
        $request->session()->flash('error.msg', 'Nenhum usuário foi encontrado.');

        return redirect()->back()->withInput();

    }


    public function delete($id)
    {
        $person = $this->repository->findByField('id', $id)->first();

        if($person)
        {
            DB::beginTransaction();

            try {

                $user = $this->users->findByField('person_id', $person->id)->first();

                if ($user){
                    $x['active'] = 0;
                    $this->users->update($x, $id);
                }

                /*$vehicles = $this->vehicles->findByField('owner_id', $id);

                foreach ($vehicles as $vehicle)
                {
                    $this->vehicles->delete($vehicle->id);
                }

                $orders = $this->orders->findByField('owner_id', $id);

                foreach ($orders as $order)
                {
                    $this->orders->delete($order->id);
                }*/

                $x['active'] = 0;
                $this->repository->update($x, $id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e){

                DB::rollBack();

                return json_encode(['status' => false, 'msg' => $e->getMessage(), 'line' => $e->getLine()]);
            }

        }
    }

    /*
     * Verify if cpf is in use by another person.
     * Verifica se o cpf está em uso por outra pessoa.
     */
    public function cpf_exists($cpf, $id = null)
    {
        $response = $this->repository->findByField('cpf', $cpf)->first();

        if($response)
        {
            if($id)
            {
                if($response->id == $id)
                    return json_encode(['status' => true]);

                return json_encode(['status' => false]);
            }

            return json_encode(['status' => false]);
        }

        return json_encode(['status' => true]);

    }

    /*
     * Reactivate deleted person
     * Reativa um usuário excluído
     */
    public function reactivate($id)
    {
        $model = $this->repository->findByField('id', $id)->first();

        if($model)
        {
            $x['active'] = 1;

            DB::beginTransaction();

            try{
                $this->repository->update($x, $id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e)
            {
                DB::rollBack();

                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }
        }

        return json_encode(['status' => false, 'msg' => 'Este usuário não existe']);
    }

    public function verify_email($email)
    {
        $person = $this->repository->findByField('email', $email)->first();

        if($person)
            return json_encode(['code' => 200]);

        return json_encode(['code' => 404]);
    }
}
