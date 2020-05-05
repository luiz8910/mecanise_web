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

    public function domains(Request $request, $length = null)
    {
        $file = fopen("https://registro.br/dominio/lista-processo-liberacao.txt", "r");
        //$file = fopen("teste.txt", "r");

        while(!feof($file))
        {

            $stop = false;

            $line = fgets($file);

            if(substr($line, 0, 1) !== "#")
            {
                $length = $length ? $length : 3;

                for ($i = 0; $i < $length; $i++)
                {
                    $char = substr($line, $i, 1);

                    if(is_numeric($char)) {
                        $stop = true;
                    }

                }

                if(!$stop)
                {
                    $point = substr($line, $length, 1);

                    if($point === "."){

                        $final = strstr($line, '.com.br');

                        if($final)
                            echo $line . "<br>";

                    }
                }
            }

        }

        fclose($file);
    }
}
