@extends('main')
@section('content')
<div class="container col-12 d-flex h-100">
    <div class="col-6">
        <table class = "table table-border data-table">
            <thead>
                <h3 class="box">Οδηγοί</h3>
                <tr>
                    <th>ID</th>
                    <th>Όνομα</th>
                    <th>Username</th>
                    <th>Τηλέφωνο</th>
                    <th>Αριθμός Πινακίδας</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($drivers as $driver)
                <tr>
                    <td>{{$driver->id}}</td>
                    <td>{{$driver->name}}</td>
                    <td>{{$driver->username}}</td>
                    <td>{{$driver->phone}}</td>
                    <td>{{$driver->vehicle}}</td>
                    
                    <td>
                        <a
                        href="{{route ('driver.delete', $driver)}}"
                        class = "btn btn-danger"
                        ><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

