<?php

namespace App\Http\Controllers;

use App\Repositories\PersonRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\WorkshopRepository;
use Illuminate\Http\Request;

class TesteController extends Controller
{

    private $personRepository;

    private $vehicleRepository;

    private $workshopRepository;

    public function __construct(PersonRepository $personRepository, VehicleRepository $vehicleRepository, WorkshopRepository $workshopRepository)
    {

        $this->personRepository = $personRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->workshopRepository = $workshopRepository;
    }

    public function get_session()
    {
        return session('workshop', false);
    }
}
