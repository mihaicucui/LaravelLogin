<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clients = Client::all();
        return view('clients.clients', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $res = $request->session()->get('customMessage');



        return view('clients.create', ['msg' => (isset($_SESSION['customErrorMessage'])) ? $_SESSION['customErrorMessage'] : false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'name'        => ['required', 'min:3'],
            'description' => 'required'
        ]);


        $client = new Client();
        $client->name = \request('name');
        $client->description = \request('description');
        $saveResult = $client->save();

        if (!$saveResult) {
            return redirect(route('clients.create'));
        }else{
//            return redirect(route('clients')->with('mess','xax'));
            //plus o eventuala verificare de success in view
            return \Redirect::route('clients')->with('mess','Client added successfully');
        }




        return redirect(route('clients'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::where('id',$id)->firstOrFail();
        return view('clients.edit',['client'=>$client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        request()->validate([
            'name'        => ['required', 'min:3'],
            'description' => 'required'
        ]);

        $client = Client::findOrFail($id);
        $client->name = \request('name');
        $client->description = \request('description');
        $client->save();
        return \Redirect::route('clients')->with('mess','Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
//        $client->forceDelete();

//        sleep(3);

        if ($client && $client->forceDelete()) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
}
