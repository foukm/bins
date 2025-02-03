@extends('main')
@section('content')

<div class="d-flex col-12">
    <div class="d-flex flex-column col-4">
        <h1>Προσθήκη Διαδρομής</h1>
        <form id="locationForm" method="POST" action="{{ route('routes.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Όνομα:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="notes">Σημειώσεις:</label>
                <textarea id="notes" name="notes" ></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-submit">Καταχώρηση</button>
        </form>
    </div>
</div>
@endsection

@push('js')

@endpush
