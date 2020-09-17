<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //public function index()
        //    {
        //        $clients = Client::all();
        //        return view('clients.clients', ['clients' => $clients]);
        //    }

        $transactions = Transaction::all();

        //return response()->json($transactions);

        return view('transactions.transactions');
    }

    public function getTransactions(Request $request)
    {
        $currentItems = $request->get('start');
        $noItems = $request->get('length');
        $draw = $request->get('draw');

        $transactionsCount = Transaction::all()->count();


        $transactionsPaged = Transaction::skip($currentItems)->take($noItems)->get();

        $searchData = $request->get('search');
        if (is_array($searchData) && isset($searchData['value'])) {
            //search stuff
            $searchData['value'];

            $filtered=Transaction::select('*')
                ->where('id',$searchData['value'])
                ->orWhere('client_id',$searchData['value'])
                ->orWhere('id',$searchData['value'])
                ->orWhere('currency','like','%'.$searchData['value'].'%')
                ->orWhere('status','like','%'.$searchData['value'].'%')
                ->get();
            $transactionsPaged = $filtered;
        }

        $response = [
            'data'            => $transactionsPaged,
            'draw'            => $draw,
            'recordsTotal'    => $transactionsCount,
            'recordsFiltered' => $transactionsCount
        ];

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
