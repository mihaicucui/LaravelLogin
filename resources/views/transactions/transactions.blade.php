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
{{--        <div class="container chart-container" style="position: relative; height: 40vh; width:80vh">--}}
{{--            <canvas id="myChart" width="400" height="400" aria-label="Hello ARIA World" role="img">--}}
{{--            </canvas>--}}
{{--        </div>--}}

        <div id="div1">
            <canvas id="myChart2" width="400" height="400" aria-label="Hello ARIA World" role="img">
            </canvas>
        </div>
    </div>

@endsection



