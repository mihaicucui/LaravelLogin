<?php

namespace App\Http\Controllers;

use App\Models\Client;

//use http\Client\Curl\User;
use App\Models\Token;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function login(Request $request)
    {

        $hashed = User::where('email', $request->get('email'))->pluck('password')->first();
        $id = User::where('email', $request->get('email'))->pluck('id')->first();

        if (!Hash::check($request->get('password'), $hashed)) {
            return response()->json([
                'status' => 'failed'
            ]);
        }

        $token = Token::createNewTokenRecord($id);

        return response()->json([
            'status' => 'success',
            'token'  => $token
        ]);

    }

    public function logout(Request $request)
    {
        if (!$request->get('token')) {
            return response()->json(['status' => 'failed']);
        }
        if(Token::where('token',$request->get('token'))->count()==0){
            return \response()->json(['status' => 'failed']);
        }

        Token::where('token', $request->get('token'))->delete();
        return \response()->json(['status' => 'success']);
    }

    public function getClients(Request $request)
    {
        $token = $request->get('token', false);
        if (!$token) {
            return abort(401);
        }
        //if not token match abort
        if(Token::where('token',$request->get('token'))->count()==0){
            return abort(401);
        }

        $clients = Client::all();
        return view('clients.clients-table', ['clients'=>$clients]);

    }
}
