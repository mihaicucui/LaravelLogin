@extends('layouts.app')

<script src="{{ asset('js/monthlyReport.js') }}"></script>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div id="chart-div">
                    <canvas id="monthlyChart" width="400" height="400" aria-label="Monthly Graph" role="img">
                    </canvas>
                </div>
            </div>
            <div class="col-sm-2">
                <form id="dateForm">
                    @csrf
                    <label for="yearSelect">Select year</label>
                    <select class="form-control" id="yearSelect" name="yearList" form="dateForm">
                        <option value="2020" selected>2020</option>
                        <option value="2019">2019</option>
                    </select>

                    <label for="monthSelect">Select month</label>
                    <select class="form-control" id="monthSelect" name="monthList" form="dateForm">
                        <option value="all" selected>All</option>
                        @foreach($months as $month)
                            <option value="{{$loop->index+1}}">{{$month}}</option>
                        @endforeach
                    </select>

                    <label for="clientSelect">Select client</label>
                    <select class="form-control" id="clientSelect" name="clientList" form="dateForm">
                        <option value="all" selected>All</option>
                        @foreach($clients as $client)
                            <option value="{{$client['id']}}">{{$client['name']}}</option>
                        @endforeach
                    </select>

                    <button id="filter-button" type="button" class="form-control btn btn-dark">Filter</button>
                </form>
            </div>
        </div>


    </div>
    </div>


@endsection
