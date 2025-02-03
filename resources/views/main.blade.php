<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <h2>Admin Panel</h2>
    </div>
{{--    <ul class="menu">
        <li><a href="{{route('bins.create')}}"><i class="fa fa-plus mr-1"></i> Προσθήκη κάδου</a></li>
        <li><a href="{{route('bins.index')}}"><i class="fa fa-recycle mr-1"></i>Προβολή κάδων</a></li>
        <li><a href="{{route('requests.create')}}"><i class="fa fa-hand-point-up mr-1"></i>Προσθήκη αιτήματος</a></li>
        <li><a href="{{route('requests.index')}}"><i class="fa fa-list-check mr-1"></i>Προβολή αιτημάτων</a></li>
        <li><a href="#logout"><i class="fa fa-arrow-right-from-bracket mr-1"></i>Logout</a></li>
    </ul>--}}
    <ul class="menu list-unstyled">
        <!-- Main Menu Item with Submenu -->
        <li>
            <a href="#submenu1" data-bs-toggle="collapse" aria-expanded="false" class="submenu-toggle d-flex justify-content-between">
                <span><i class="fa fa-recycle mr-1"></i>Κάδοι</span>
                <i class="fa fa-chevron-down submenu-arrow"></i>
            </a>
            <ul class="submenu collapse" id="submenu1">
                <li><a href="{{route('bins.index')}}"><i class="fa fa-list-check mr-1"></i>Προβολή κάδων</a></li>
                <li><a href="{{route('bins.create')}}"><i class="fa fa-plus mr-1"></i>Προσθήκη κάδου</a></li>
            </ul>

            <a href="#submenu2" data-bs-toggle="collapse" aria-expanded="false" class="submenu-toggle d-flex justify-content-between">
                <span><i class="fa fa-hand-point-up mr-1"></i>Αιτήματα</span>
                <i class="fa fa-chevron-down submenu-arrow"></i>
            </a>
            <ul class="submenu collapse" id="submenu2">
                <li><a href="{{route('requests.index')}}"><i class="fa fa-list-check mr-1"></i>Προβολή αιτημάτων</a></li>
                <li><a href="{{route('requests.create')}}"><i class="fa fa-hand-point-up mr-1"></i>Προσθήκη αιτήματος</a></li>
                <li><a href="{{route('requests.assign')}}"><i class="fa fa-link mr-1"></i>Ανάθεση αιτημάτων</a></li>
            </ul>
            <a href="#submenu3" data-bs-toggle="collapse" aria-expanded="false" class="submenu-toggle d-flex justify-content-between">
                <span><i class="fa fa-route mr-1"></i>Διαδρομές</span>
                <i class="fa fa-chevron-down submenu-arrow"></i>
            </a>
            <ul class="submenu collapse" id="submenu3">
                <li><a href="{{route('routes.index')}}"><i class="fa fa-list-check mr-1"></i>Προβολή Διαδρομών</a></li>
                <li><a href="{{route('routes.create')}}"><i class="fa fa-plus mr-1"></i>Προσθήκη διαδρομής</a></li>
                <li><a href="{{route('requests.byDriver')}}"><i class="fa fa-map-location-dot mr-1"></i>  Σημεία ανα διαδρομή</a></li>
                <li><a href="{{route('routes.assign')}}"><i class="fa fa-link mr-1"></i>Ανάθεση διαδρομής σε οδηγό</a></li>
            </ul>
            

            <a href="#submenu4" data-bs-toggle="collapse" aria-expanded="false" class="submenu-toggle d-flex justify-content-between">
                <span><i class="fa-solid fa-car mr-1"></i> Οδηγοί</span>
                <i class="fa fa-chevron-down submenu-arrow"></i>
            </a>
            <ul class="submenu collapse" id="submenu4">
                <li><a href="{{route('drivers.index')}}"><i class="fa fa-list-check mr-1"></i>Προβολή Οδηγών</a></li>
                <li><a href="{{route('drivers.create')}}"><i class="fa fa-plus mr-1"></i>Προσθήκη Οδηγού</a></li>
                <li><a href="{{route('routes.byDriver')}}"><i class="fa fa-plus mr-1"></i>Διαδρομές ανα οδηγό</a></li>
            </ul>
            <a href="#logout"><i class="fa fa-arrow-right-from-bracket mr-1"></i>Logout</a>
        </li>
    </ul>

</div>

<div class="content vh-100">
    @yield('content')

</div>
@stack('js')
</body>
</html>
