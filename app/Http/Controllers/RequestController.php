<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use App\Models\UserRequest;
use App\Models\MaterialRequest; // Φορτώνουμε το μοντέλο για τα MaterialRequests

class RequestController extends Controller
{
    //

    public function showByDriver(Request $request)
    {
        // Φέρνουμε όλους τους drivers
        $routes = Route::all();
    
        // Παίρνουμε το επιλεγμένο id του driver από το request
        $selectedRouteId = $request->input('route_id'); // Η τιμή είναι το `id` του driver
    
        // Επιστρέφουμε τα requests για τον επιλεγμένο driver, αν υπάρχει επιλεγμένο driver_id
        $requests = $selectedRouteId
            ? UserRequest::where('assigned_to', $selectedRouteId)->get() // Φιλτράρουμε τα αιτήματα για τον επιλεγμένο driver
            : collect(); // Αν δεν έχει επιλεγεί driver, επιστρέφουμε κενή συλλογή
    
        // Επιστρέφουμε τη view με τους drivers και τα requests
        return view('requests.showRequests', compact('routes', 'requests', 'selectedRouteId'));
    }

    
    public function index()
    {
        $requests = UserRequest::all();
       return view('requests.index',['requests'=>$requests]);

    }
    public function create()
    {
        return view('requests.create');
    }


    public function delete(UserRequest $request)
    {
        $request->delete();
        return redirect()->route('requests.index');
    }

    public function store(Request $request)
    {
        $request = UserRequest::create([
            'name' => $request->input('name'),
            'category'=>$request->input('category'),
            'lat' => $request->input('latitude'),
            'lon' => $request->input('longitude'),
            'phone'=>$request->input('phone'),
            'info'=>$request->input('info'),
            'address'=>$request->input('address'),
        ]);

        return redirect()->route('requests.index');
    }


    public function assignRequests(Request $request)
    {
        $requests = UserRequest::query()->with('route')->get();
        $routes = Route::all();
        return view('routes.assign',['routes'=>$routes, 'requests' => $requests]);
    }

    public function storeAssign(Request $request, UserRequest $userRequest, Route $route){
        $userRequest->is_assigned = true;
        $userRequest->assigned_to = $route->id;
        $userRequest->save();
        return response()->json(['success'=>true]);
    }
}
