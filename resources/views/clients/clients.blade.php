@extends('layouts.app')

@section('content')
    {{--    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">--}}
    {{--        Launch demo modal--}}
    {{--    </button>--}}

    <!-- Modal -->

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really want to delete this client? This process cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="delete-modal-btn" data-id="0" type="button" class="btn btn-danger">Delete</button>
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                </div>
            </div>
        </div>
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
            <p>{{Session::get('mess')}}</p>
            @foreach($clients as $client)
                <tr id="client-row-{{$client->id}}">
                    <td>{{$client->id}}</td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->description}}</td>
                    <td>

                        <a href="/clients/{{$client->id}}/edit" class="btn btn-dark edit-btn" data-id="{{$client->id}}"><i
                                class="fa fa-edit"></i></a>
                        <button type="button" class="btn btn-dark delete-btn" data-toggle="modal"
                                data-target="#deleteModal"
                                data-id="{{$client->id}}"><i class="fa fa-trash"></i></button>
                        <div id="spinner" class="spinner-border spinner-border-sm" role="status" hidden>
                            <span class="sr-only">Loading...</span>
                        </div>

                    </td>
                </tr>
            @endforeach
        </table>
        <div>
@endsection
