<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use DB;

class TransactionController extends Controller
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
        DB::enableQueryLog();

        $currentItems = $request->get('start');
        $noItems = $request->get('length');
        $draw = $request->get('draw');
        $searchData = $request->get('search');
        $orderByArray = $request->get('order');
        $dbColumns = Schema::getColumnListing('transactions');


        if (is_array($searchData) && isset($searchData['value'])) {
            $transactionsQuery = Transaction::select('*')->where('id', $searchData['value'])
                ->orWhere('id', $searchData['value'])
                ->orWhere('currency', 'like', '%' . $searchData['value'] . '%')
                ->orWhere('status', 'like', '%' . $searchData['value'] . '%');

            if (is_numeric($searchData['value'])) {
                $transactionsQuery = $transactionsQuery->orWhere('client_id', $searchData['value']);
            }

        } else {
            $transactionsQuery = Transaction::select('*');
        }


        foreach ($orderByArray as $orderItem) {
            $column = $dbColumns[$orderItem['column']];
            $transactionsQuery = $transactionsQuery->orderBy($column, $orderItem['dir']);
        }

        $filteredCount = $transactionsQuery->count();

        $transactionsPaged = $transactionsQuery->skip($currentItems)->take($noItems)->get();

        foreach ($transactionsPaged as $transaction) {
            if (!$transaction->client) {
                $transaction->client_name = '-';
            } else {
                $transaction->client_name = $transaction->client->name;
            }
        }





        $response = [
            'data'            => $transactionsPaged,
            'draw'            => $draw,
            'recordsTotal'    => Transaction::all()->count(),
            'recordsFiltered' => $filteredCount
        ];

        return response()->json($response);
    }

    public function getDividedByStatus(){
        $successNo = Transaction::where('status','SUCCESS')->count();
        $pendingNo = Transaction::where('status','PENDING')->count();
        $failedNo = Transaction::where('status','FAILED')->count();


        $response = [
            'success'=>$successNo,
            'pending'=>$pendingNo,
            'failed'=>$failedNo
        ];
        return response()->json($response);
    }

    public function getDividedByMonth(){
        $monthsValue=[];

        for($i=1;$i<=12;$i++){
            $successNo = Transaction::whereMonth('created_at',strval($i))->where('status','SUCCESS')->count();
            $pendingNo = Transaction::whereMonth('created_at',strval($i))->where('status','PENDING')->count();
            $failedNo = Transaction::whereMonth('created_at',strval($i))->where('status','FAILED')->count();
            $monthsValue[$i] = [
                'success'=>$successNo,
                'pending'=>$pendingNo,
                'failed'=>$failedNo
            ];
        }
        return response()->json($monthsValue);
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
