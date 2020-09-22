<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

//    protected $appends = ['client_name'];
//
//
    public function client()
    {
        return $this->hasOne('App\Models\Client', 'id', 'client_id');
    }
//
//    public function getClientNameAttribute(){
//        $client=Client::where('id', $this->client_id)->first;
//        return $client->name;
//    }

}
