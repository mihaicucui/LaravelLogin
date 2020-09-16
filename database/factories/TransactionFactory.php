<?php

namespace Database\Factories;

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

        $status = ['PENDING', 'SUCCESS', 'FAILED'];
        return [
            'client_id'=> rand(0,1000),
            'amount'=>rand(0,1000000),
            'code'=>rand(0,1000),
            'currency'=>Str::random(2),
            'status'=>$status[rand(0,2)]
        ];
    }
}
