<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use App\Models\Driver;
class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        $requests = UserRequest::all();

        return view('routes.index',['routes'=>$routes, 'requests' => $requests]);

    }
    public function create()
    {
        return view('routes.create');
    }

    public function showByDriver(Request $request)
    {


        $drivers=Driver::all();
        // Παίρνουμε το επιλεγμένο id του driver από το request
        $selectedDriverId = $request->input('driver_id'); // Η τιμή είναι το `id` του driver
    
        // Επιστρέφουμε τα requests για τον επιλεγμένο driver, αν υπάρχει επιλεγμένο driver_id
        $routes = $selectedDriverId
            ? Route::where('assigned_to', $selectedDriverId)->get() // Φιλτράρουμε τα αιτήματα για τον επιλεγμένο driver
            : collect(); // Αν δεν έχει επιλεγεί driver, επιστρέφουμε κενή συλλογή
   
        // Επιστρέφουμε τη view με τους drivers και τα requests
        return view('drivers.showRequests', compact('drivers','routes', 'selectedDriverId'));
    }

    public function assignRoutes(Route $route)
    {
        $routes = Route::query()->with('driver')->get();
        $drivers = Driver::all();
        return view('drivers.assign',['drivers'=>$drivers, 'routes' => $routes]);
    }

    public function storeAssign(Request $request, Route $route, Driver $driver){
        $route->is_assigned = true;
        $route->assigned_to = $driver->id;
        $route->save();
        return response()->json(['success'=>true]);
    }

    public function delete(Route $route)
    {
        $route->delete();
        return redirect()->route('routes.index');
    }

    public function store(Request $request)
    {
        $request = Route::create([
            'name' => $request->input('name'),
            'notes'=>$request->input('notes'),
        ]);

        return redirect()->route('routes.index');
    }
}
