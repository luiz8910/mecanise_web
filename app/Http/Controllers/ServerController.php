<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function deploy()
    {
        SSH::into('production')->run();
    }
}
