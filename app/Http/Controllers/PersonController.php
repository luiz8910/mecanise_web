<?php

namespace App\Http\Controllers;

use App\Repositories\PersonRepository;
use App\Repositories\RolesRepository;
use App\Repositories\StatesRepository;
use App\Repositories\UserRepository;
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
    private $workshopRepository;
    /**
     * @var RolesRepository
     */
    private $rolesRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var StatesRepository
     */
    private $statesRepository;

    public function __construct(PersonRepository $repository, UserRepository $userRepository,
                                WorkshopRepository $workshopRepository, RolesRepository $rolesRepository,
                                StatesRepository $statesRepository)
    {

        $this->repository = $repository;
        $this->workshopRepository = $workshopRepository;
        $this->rolesRepository = $rolesRepository;
        $this->userRepository = $userRepository;
        $this->statesRepository = $statesRepository;
    }

    public function index()
    {
        $workshop = $this->workshopRepository->findByField('id', $this->get_user_workshop())->first();

        if($workshop)
        {
            $people = $workshop->people;
        }

        $route = 'people.list-default';

        foreach ($people as $person)
        {
            $person->initials = $this->initials($person->name);

            $person->role_name = $this->rolesRepository->findByField('id', $person->role_id)->first() ?
                $this->rolesRepository->findByField('id', $person->role_id)->first()->name : 'Cargo não definido';

            $person->created_at_str = date_format(date_create($person->created_at), 'd/m/Y');
        }

        $people_qtde = count($people);

        return view('index', compact('route', 'people', 'people_qtde'));
    }

    public function index_table()
    {
        $scripts[] = 'assets/js/pages/crud/metronic-datatable/base/html-table.js';

        $workshop = $this->workshopRepository->findByField('id', $this->get_user_workshop())->first();

        if($workshop)
        {
            $people = $workshop->people;
        }

        $route = 'people.list-table';

        foreach ($people as $person)
        {
            $person->initials = $this->initials($person->name);

            $person->role_name = $this->rolesRepository->findByField('id', $person->role_id)->first() ?
                $this->rolesRepository->findByField('id', $person->role_id)->first()->name : 'Cargo não definido';

            $person->created_at_str = date_format(date_create($person->created_at), 'd/m/Y');
        }

        $people_qtde = count($people);

        return view('index', compact('route', 'people', 'people_qtde', 'scripts'));
    }

    public function employees()
    {
        $workshop = $this->workshopRepository->findByField('id', $this->get_user_workshop())->first();

        if($workshop)
        {
            $people = $this->repository->findByField('role_id', 2);
        }

        return $people;
        //TODO: return view
    }

    public function create()
    {
        $links[] = '../../assets/css/pages/wizard/wizard-4.css';

        //$scripts[] = '../../assets/js/pages/custom/user/add-user.js';
        $scripts[] = '../../js/person.js';
        $scripts[] = '../../js/address.js';
        $scripts[] = '../../assets/js/pages/crud/forms/widgets/bootstrap-maxlength.js';

        $route = 'people.form';

        $roles = $this->rolesRepository->all();

        $states = $this->statesRepository->all();

        $edit = false;

        return view('index', compact('links', 'route', 'roles', 'scripts', 'states', 'edit'));
    }

    //$id = person id
    public function edit($id)
    {
        $person = $this->repository->findByField('id', $id)->first();

        if($person)
        {
            $links[] = '../../assets/css/pages/wizard/wizard-4.css';

            //$scripts[] = '../../assets/js/pages/custom/user/add-user.js';
            $scripts[] = '../../js/person.js';
            $scripts[] = '../../js/address.js';
            $scripts[] = '../../assets/js/pages/crud/forms/widgets/bootstrap-maxlength.js';

            $route = 'people.form';

            $roles = $this->rolesRepository->all();

            $states = $this->statesRepository->all();

            $edit = true;

            return view('index', compact('links', 'route', 'person', 'roles', 'scripts', 'states', 'edit'));
        }

        Session::flash('error.msg', 'Usuário não existe');

        return redirect()->route('home.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();

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

                    $this->userRepository->create($u);

                    DB::commit();

                    $request->session()->flash('success.msg', 'O usuário foi cadastrado com sucesso');

                    return isset($data['origin']) ? json_encode(['status' => true, 'id' => $person_id]) : redirect()->route('person.index');

                }
            }
        }catch (\Exception $e){
            DB::rollBack();

            $request->session()->flash('error.msg', 'Um erro desconhecido ocorreu');

            return isset($data['origin']) ? json_encode(['status' => false, 'msg' => 'Um erro desconhecido ocorreu']) :
                redirect()->back();
        }

    }

    public function store_old(Request $request)
    {
        $data = $request->all();

        $data['workshop_id'] = $this->get_user_workshop();

        $user = $data['email'] != "" ? $this->userRepository->findByField('email', $data['email'])->first() : false;

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

            $this->userRepository->create($u);

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
                    if($this->workshopRepository->findByField('email', $data['email'])->first())
                    {
                        //Return message informing the error
                        $request->session()->flash('error.msg', 'Este email está sendo usado por outra pessoa, tente outro email.');
                        return redirect()->back()->withInput();
                    }
                    //In case the new email is not in use, it changes email for login
                    else{
                        $user = $this->userRepository->findByField('email', $person->email)->first();

                        if($user)
                        {
                            $this->userRepository->update($data['email'], $user->id);
                        }
                    }
                }

                DB::beginTransaction();

                try{

                    if($data['dateBirth'])
                    {
                        $data['dateBirth'] = date_format(date_create($data['dateBirth']), 'Y-m-d');
                    }

                    $this->repository->update($data, $id);

                    DB::commit();

                    $request->session()->flash('success.msg', 'O usuário foi alterado com sucesso');

                    return redirect()->route('person.index');

                }catch (\Exception $e)
                {
                    DB::rollBack();

                    $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

                    return redirect()->back()->withInput();
                }

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

            try{
                $this->userRepository->delete($person->user->id);

                $this->repository->delete($id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e){

                DB::rollBack();

                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }

        }
    }
}
