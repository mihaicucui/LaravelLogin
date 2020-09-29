<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Token extends Model
{
    use HasFactory;

    protected $table = 'logged_in';

    public static function createNewTokenRecord($id)
    {
        if (Token::where('user_id', $id)->count() != 0) {
            $token = Token::where('user_id', $id)->pluck('token')->first();
            return $token;
        }

        $email = User::where('id', $id)->pluck('email')->first();
        $token = Hash::make($email . $id);

        $loggedIn = new Token();
        $loggedIn->user_id = $id;
        $loggedIn->token = $token;
        $loggedIn->save();

        return $token;
    }

}
