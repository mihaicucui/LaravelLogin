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
