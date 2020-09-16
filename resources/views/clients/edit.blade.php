@extends('layouts.app')

@section('content')
    <div class="container container-sm">
        <div class="my-smaller-container">
            <h3>Edit client {{$client->id}}</h3>
            <form method="POST" action="/clients/{{$client->id}}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" placeholder="Name" name="name"
                           value="{{$client->name}}">
                    <p class="text-danger">{{$errors->first('name')}}</p>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control @error('description')is-invalid @enderror" id="description" placeholder="Description"
                           name="description" value="{{$client->description}}">
                    <p class="text-danger">{{$errors->first('description')}}</p>

                </div>
                <button type="submit" class="btn btn-primary btn-dark">Update</button>
            </form>
        </div>
    </div>
@endsection
