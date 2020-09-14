@extends('layouts.app')

@section('content')
    <div>

    </div>
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Operations</th>
            </tr>
            </thead>
            @foreach($clients as $client)
                <tr>
                    <td>{{$client->id}}</td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->description}}</td>
                    <td><button type="button" class="btn btn-dark" data-id="{{$client->id}}"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-dark" data-id="{{$client->id}}"><i class="fa fa-trash"></i></button></td>
                </tr>
            @endforeach
        </table>
        <div>
@endsection
