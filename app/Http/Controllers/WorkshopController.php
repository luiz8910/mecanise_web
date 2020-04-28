<?php

namespace App\Http\Controllers;

use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkshopRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkshopController extends Controller
{
    private $repository;
    private $personRepository;
    private $userRepository;

    public function __construct(WorkshopRepository $repository, PersonRepository $personRepository, UserRepository $userRepository)
    {

        $this->repository = $repository;
        $this->personRepository = $personRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * List Active Workshops
     */
    public function index()
    {
        $w_shops = $this->repository->all();

        return view('index', compact('w_shops'));
    }

    /**
     * Create a new Workshop
     */
    public function create()
    {

    }

    /**
     * Edit details of selected workshop
     * @param $id = workshop id
     */
    public function edit($id)
    {

    }

    /**
     * Store new workshop data
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        //Search if a responsible person is already stored
        if($this->personRepository->findByField('email', $data['email'])->first())
        {
            $request->session()->flash('error.msg', 'Este usuário já existe');

            return redirect()->back()->withInput();
        }

        $person['name'] = $data['person_name'];
        $person['email'] = $data['person_email'] ? $data['person_email'] : $data['email'];
        $person['dateBirth'] = $data['dateBirth'] ? date_format(date_create($person['dateBirth']), 'Y-m-d') : null;
        $person['cel'] = $data['person_cel'] ? $data['person_cel'] : $data['cel'];
        $person['gender'] = $data['gender'];
        $person['description'] = $data['person_description'];
        $person['zip_code'] = $data['person_zip_code'];
        $person['street'] = $data['person_street'];
        $person['number'] = $data['person_number'];
        $person['district'] = $data['person_district'];
        $person['city'] = $data['person_city'];
        $person['state'] = $data['person_state'];
        $person['address_reference'] = $data['person_address_reference'];

        DB::beginTransaction();

        try{
            $person_id = $this->personRepository->create($person)->id;

            $data['responsible_id'] = $person_id;

            $w_shop_id = $this->repository->create($data)->id;

            $p['workshop_id'] = $w_shop_id;

            $this->personRepository->update($p, $person_id);

            DB::commit();

            $request->session()->flash('success.msg', 'A oficina foi cadastrada com sucesso');

            return redirect()->back();

        }catch (\Exception $e)
        {
            DB::rollBack();

            $request->session()->flash('error.msg', 'Um bug ocorreu');

        }

        return redirect()->back()->withInput();

    }

    /**
     * Update selected workshop data
     * @param Request $request
     * @param $id = workshop id
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $workshop = $this->repository->findByField('id', $id)->first();

        if($workshop)
        {
            if($data['email'] != $workshop->email)
            {
                //Search if a responsible person is already stored
                if($this->personRepository->findByField('email', $data['email'])->first())
                {
                    $request->session()->flash('error.msg', 'Este usuário já existe');

                    return redirect()->back()->withInput();
                }
            }

            $person['name'] = $data['person_name'];
            $person['email'] = $data['person_email'] ? $data['person_email'] : $data['email'];
            $person['dateBirth'] = $data['dateBirth'] ? date_format(date_create($person['dateBirth']), 'Y-m-d') : null;
            $person['cel'] = $data['person_cel'] ? $data['person_cel'] : $data['cel'];
            $person['gender'] = $data['gender'];
            $person['description'] = $data['person_description'];
            $person['zip_code'] = $data['person_zip_code'];
            $person['street'] = $data['person_street'];
            $person['number'] = $data['person_number'];
            $person['district'] = $data['person_district'];
            $person['city'] = $data['person_city'];
            $person['state'] = $data['person_state'];
            $person['address_reference'] = $data['person_address_reference'];

            DB::beginTransaction();

            try{

                $new_id = $this->personRepository->findByField('email', $person['email'])->first();

                if($new_id)
                {
                    $person_id = $new_id;
                    $this->personRepository->update($person, $new_id);
                }
                else{

                    $person_id = $this->personRepository->create($person)->id;
                }

                $data['responsible_id'] = $person_id;

                $this->repository->update($data, $id);

                $p['workshop_id'] = $id;

                $this->personRepository->update($p, $person_id);

                DB::commit();

                $request->session()->flash('success.msg', 'A oficina foi cadastrada com sucesso');

                return redirect()->back();

            }catch (\Exception $e)
            {
                DB::rollBack();

                $request->session()->flash('error.msg', 'Um bug ocorreu');

            }

        }

        $request->session()->flash('error.msg', 'Esta oficina não existe');

        return redirect()->back()->withInput();
    }

    /**
     * Delete selected workshop
     * @param $id
     */
    public function delete($id)
    {
        $workshop = $this->repository->findByField('id', $id)->first();

        if($workshop)
        {
            DB::beginTransaction();

            try{

                $this->repository->delete($id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e){

                DB::rollBack();

                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }
        }

        return json_encode(['status' => false, 'msg' => 'Esta oficina não existe']);
    }
}
