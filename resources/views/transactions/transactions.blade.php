@extends('layouts.app')

@section('content')

    <div class="container">
        <table id="transactions-table" class="table">
            <thead>
            <tr>
                <th>id</th>
                <th>client_id</th>
                <th>amount</th>
                <th>currency</th>
                <th>status</th>
                <th>client_name</th>
            </tr>
            </thead>
            <tbody>
            {{--            @foreach($transactions as $transaction)--}}
            {{--                <tr>--}}
            {{--                    <td>{{$transaction->id}}</td>--}}
            {{--                    <td>{{$transaction->client_id}}</td>--}}
            {{--                    <td>{{$transaction->amount}}</td>--}}
            {{--                    <td>{{$transaction->currency}}</td>--}}
            {{--                    <td>{{$transaction->status}}</td>--}}
            {{--                </tr>--}}
            {{--            @endforeach--}}
            </tbody>


        </table>


        <div id="div1" style="height:600px; width: 800px;">
            <canvas id="myChart2" width="400" height="400" aria-label="Hello ARIA World" role="img">
            </canvas>
        </div>
    </div>

@endsection



