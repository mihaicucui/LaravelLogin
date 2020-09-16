@extends('layouts.app')

@section('content')
    <div class="container container-sm">
        <div class="my-smaller-container">
            @if ($msg)
                <p>{{$msg}}</p>
            @endif
            <form method="POST" action="/clients/create">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" placeholder="Name" name="name"
                           value="{{old('name')}}">
                    <p class="text-danger">{{$errors->first('name')}}</p>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control @error('description')is-invalid @enderror" id="description" placeholder="Description"
                           name="description" value="{{old('description')}}">
                    <p class="text-danger">{{$errors->first('description')}}</p>

                </div>
                <button type="submit" class="btn btn-primary btn-dark">Submit</button>
            </form>
        </div>
    </div>
@endsection
