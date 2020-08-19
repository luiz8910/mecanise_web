<?php

namespace App\Imports;

use App\Models\Car;
use App\Models\Parts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class PartsImportNGK implements ToCollection
{
    private $part_id;

    public function __construct($part_id)
    {
        $this->part_id = $part_id;
    }

    /**
     * @param Collection $collections
     */
    public function collection(Collection $collections)
    {

        $cars = new Car();
        $parts = new Parts();

        $x = 0;

        $car_model = '';

        $num_columns = count($collections[0]);

        for($i = 0; $i < count($collections); $i++)
        {
            if($i === 0)
            {
                $brand = $collections[0][0] != "" ? $collections[0][0] : null;

                if($brand)
                {
                    $brand = strtoupper($brand);

                    $exists = DB::table('car_brands')
                        ->where('name', $brand)
                        ->first();

                    if(!$exists)
                        return 'Esta marca ' . $brand . ' não existe';

                }
            }
            else{

                if($collections[$i][$x]){

                    $car_model = str_replace("/", "-", $collections[$i][$x]);
                    $car_version = str_replace("/", "-", $collections[$i][1]);
                }
                else{
                    $car_version = str_replace("/", "-", $collections[$i][1]);
                }

                echo strtoupper($car_model) . " " . strtoupper($car_version) . "<br>";

                $year = explode("a", $collections[$i][$num_columns - 2]);

                $model = DB::table('cars')
                    ->where(
                        'model', 'like', "%".strtoupper($car_model) . " " . strtoupper($car_version)
                    )
                    ->whereNull('deleted_at')
                    ->first();

                //dd($model);


                if($model)
                {
                    $parts_exists = $parts->where(
                        [
                            'part_id' => $this->part_id,
                            'car_id' => $model->id,
                            'brand_code' => $collections[$i][$num_columns - 1],
                            'start_year' => trim($year[0]),
                            'end_year' => trim($year[1]),
                        ])->first();

                    if(!$parts_exists)
                    {
                        $parts->part_id = $this->part_id;
                        $parts->car_id = $model->id;
                        $parts->brand_code = $collections[$i][$num_columns - 1];
                        $parts->brand_parts_id = 1;
                        $parts->start_year = trim($year[0]);
                        $parts->end_year = trim($year[1]);
                        $parts->system_id = 1;

                        $parts->save();
                    }
                    else{
                        echo 'parts exists: ' . $collections[$i][$num_columns - 1] . "<br>";
                    }

                }
                else{
                    echo 'model does not exists: ' . $car_model . " " . $car_version . "<br>";
                }


            }

        }
    }
}
