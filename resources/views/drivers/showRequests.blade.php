<!-- resources/views/requests/showRequests.blade.php -->
@extends('main')
@section('content')
<form method="GET" action="{{ route('routes.byDriver') }}">
    <label for="driver">Επιλογή Διαδρομής:</label>
    <select name="driver_id" id="driver" onchange="this.form.submit()">
        <option value="">--Επιλέξτε Οδηγό--</option>
        @foreach ($drivers as $driver)
            <option value="{{ $driver->id }}" {{ $selectedDriverId == $driver->id ? 'selected' : '' }}>
                {{ $driver->name }}
            </option>
        @endforeach
    </select>
</form>
@if($routes->isNotEmpty())
<div class="d-flex flex-column h-100">
    <div>
        <table class = "table table-border data-table">
            <thead>
                <h3 class="box">Διαδρομή</h3>
                <tr>
                    <th>ID</th>
                    <th>Όνομα</th>
                    <th>Περιγραφή</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($routes as $route)
                <tr>
                    <td>{{$route->id}}</td>
                    <td>{{$route->name}}</td>
                    <td>{{$route->notes}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@elseif($selectedDriverId)
    <p>Δεν υπάρχει επιλεγμένη διαδρομή.</p>
@endif
@endsection



