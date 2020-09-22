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
        $months=[];
        for ($m=1; $m<=12; $m++) {
            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
            array_push($months,$month);
        }
        $status = ['PENDING', 'SUCCESS', 'FAILED'];
        return [
            'client_id'=> Client::factory()->create(),
            'amount'=>rand(0,1000000),
            'code'=>rand(0,1000),
            'currency'=>Str::random(2),
            'status'=>$status[rand(0,2)],
            'created_at'=>$months[rand(0,11)]
        ];
    }
}


