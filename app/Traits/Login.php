<?php

namespace App\Traits;

use App\Mail\NewUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

trait Login{

    //use Config;

    public function reset_pass($data)
    {
        return DB::table('password_resets')
            ->insert([
                'email' => $data['email'],
                'token' => $data['token'],
                'created_at' => $data['created_at'],
                'expires_in' => $data['expires_in']
            ]);
    }

    public function new_user($data)
    {
        $password = $this->random_password(6);

        DB::beginTransaction();

        try {
            DB::table('users')
                ->insert([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'person_id' => $data['person_id'],
                    'password' => Hash::make($password),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            Mail::to($data['email'])->send(new NewUser($data['name'], $password));

            DB::commit();

            return true;

        }catch (\Exception $e)
        {
            DB::rollBack();

            dd($e);
        }

    }

    public function random_password($length = null)
    {
        $length = $length ? $length : 5;

        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
