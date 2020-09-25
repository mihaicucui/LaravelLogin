<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use DB;
use function GuzzleHttp\Psr7\str;

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
            $transactionsQuery = Transaction::select('*')->join('clients', 'transactions.client_id', '=', 'clients.id')
                ->where('transactions.id', $searchData['value'])
                ->orWhere('transactions.currency', 'like', '%' . $searchData['value'] . '%')
                ->orWhere('transactions.status', 'like', '%' . $searchData['value'] . '%')
                ->orWhere('clients.name', 'like', '%' . $searchData['value'] . '%');


            if (is_numeric($searchData['value'])) {
                $transactionsQuery = $transactionsQuery->orWhere('client_id', $searchData['value']);
            }

        } else {
            $transactionsQuery = Transaction::select('*');
        }


        foreach ($orderByArray as $orderItem) {
            $column = $dbColumns[$orderItem['column']];
            if ($column == 'client_name') {
                $column = 'clients.name';
            } else {
                $column = 'transactions.' . $column;
            }
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

    public function getDividedByStatus()
    {
        $successNo = Transaction::where('status', 'SUCCESS')->count();
        $pendingNo = Transaction::where('status', 'PENDING')->count();
        $failedNo = Transaction::where('status', 'FAILED')->count();


        $response = [
            'success' => $successNo,
            'pending' => $pendingNo,
            'failed'  => $failedNo
        ];
        return response()->json($response);
    }

    public function getDividedByMonth($year)
    {
        $monthsValue = [];
        $yearTransactions = Transaction::whereYear('created_at', strval($year));
        for ($i = 1; $i <= 12; $i++) {
            $successNo = $yearTransactions->whereMonth('created_at', strval($i))->where('status', 'SUCCESS')->count();
            $pendingNo = $yearTransactions->whereMonth('created_at', strval($i))->where('status', 'PENDING')->count();
            $failedNo = $yearTransactions->whereMonth('created_at', strval($i))->where('status', 'FAILED')->count();
            $monthsValue[$i] = [
                'success' => $successNo,
                'pending' => $pendingNo,
                'failed'  => $failedNo
            ];
        }
        return response()->json($monthsValue);
    }

    public function filterForGraph(Request $request)
    {

        $all = 'all';
        $year = $request->input('yearList');//get selected year
        $month = $request->input('monthList');//get selected month
        $client = $request->input('clientList');//get selected client

        if ($month == 'all') {
            $monthsValue = [];
            $monthsValue[0] = [
                'labels' => [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ]
            ];
            if ($client == 'all') {


                for ($i = 1; $i <= 12; $i++) {
                    $successNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                        strval($i))->where('status', 'SUCCESS')->count();

                    $pendingNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                        strval($i))->where('status',
                        'PENDING')->count();
                    $failedNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                        strval($i))->where('status',
                        'FAILED')->count();
                    $monthsValue[$i] = [
                        'success' => $successNo,
                        'pending' => $pendingNo,
                        'failed'  => $failedNo
                    ];
                }
                return response()->json($monthsValue);
            } else {
                if ($client) {
                    for ($i = 1; $i <= 12; $i++) {
                        $successNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                            strval($i))->where('status', 'SUCCESS')->where('client_id', $client)->count();

                        $pendingNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                            strval($i))->where('status',
                            'PENDING')->where('client_id', $client)->count();

                        $failedNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                            strval($i))->where('status',
                            'FAILED')->where('client_id', $client)->count();

                        $monthsValue[$i] = [
                            'success' => $successNo,
                            'pending' => $pendingNo,
                            'failed'  => $failedNo
                        ];
                    }
                    return response()->json($monthsValue);
                }
            }
        } else {
            $daysValue = [];
            $daysNumber = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $daysArray = range(1, $daysNumber);
            $daysValue[0] = ['labels' => $daysArray];

            if ($client == 'all') {
                for ($i = 1; $i <= $daysNumber; $i++) {
                    $successNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                        $month)->whereDay('created_at', $i)
                        ->where('status', 'SUCCESS')->count();

                    $pendingNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                        $month)->whereDay('created_at', $i)
                        ->where('status', 'PENDING')->count();

                    $failedNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                        $month)->whereDay('created_at', $i)
                        ->where('status', 'FAILED')->count();

                    $daysValue[$i] = [
                        'success' => $successNo,
                        'pending' => $pendingNo,
                        'failed'  => $failedNo
                    ];
                }
                return response()->json($daysValue);
            }
            else{
                if($client){
                    for ($i = 1; $i <= $daysNumber; $i++) {
                        $successNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                            $month)->whereDay('created_at', $i)->where('client_id',$client)
                            ->where('status', 'SUCCESS')->count();

                        $pendingNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                            $month)->whereDay('created_at', $i)->where('client_id',$client)
                            ->where('status', 'PENDING')->count();

                        $failedNo = Transaction::whereYear('created_at', $year)->whereMonth('created_at',
                            $month)->whereDay('created_at', $i)->where('client_id',$client)
                            ->where('status', 'FAILED')->count();

                        $daysValue[$i] = [
                            'success' => $successNo,
                            'pending' => $pendingNo,
                            'failed'  => $failedNo
                        ];
                    }
                    return response()->json($daysValue);
                }
            }
        }
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
