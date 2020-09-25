<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $clientIds = Client::all()->pluck('id')->toArray();
//        $months = [];
//        for ($m = 1; $m <= 12; $m++) {
//            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
//
//            'Y-m-d H:i:s';
//
//            $randomMonth = rand(1, 12);
//
//            $maxNumberOfDays = 11;//todo
//
//            $random2019Date = 2019 . '-' . $randomMonth . '-' . rand(1, $maxNumberOfDays) . ' 00:00:00';
//
//            array_push($months, $month);
//        }
        $month = rand(1,12);
        $year= rand(0,1)+2019;
        $created_at= $year . '-' . $month . '-' .rand(1,cal_days_in_month(CAL_GREGORIAN, $month, $year)) . '00:00:00';
        $status = ['PENDING', 'SUCCESS', 'FAILED'];
        return [
            'client_id'  => $clientIds[rand(0,count($clientIds)-1)],
            'amount'     => rand(0, 1000000),
            'code'       => rand(0, 1000),
            'currency'   => Str::random(2),
            'status'     => $status[rand(0, 2)],
            'created_at' => $created_at,
            'updated_at' => $created_at
        ];
    }
}


