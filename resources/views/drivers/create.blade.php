@extends('main')
@section('content')

<div class="d-flex col-12">
    <div class="d-flex flex-column col-4">
        <h1>Προσθήκη Οδηγού</h1>
        <form id="locationForm" method="POST" action="{{ route('drivers.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Όνομα:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="usernmame">Username:</label>
                <textarea id="usernmae" name="username" ></textarea>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="phone">Τηλέφωνο:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="vehicle">Αριθμός Πινακίδας Οχήματος:</label>
                <input type="vehicle" id="vehicle" name="vehicle" required>
            </div>
            <button type="submit" class="btn btn-primary btn-submit">Καταχώρηση</button>
        </form>
    </div>
</div>
@endsection

