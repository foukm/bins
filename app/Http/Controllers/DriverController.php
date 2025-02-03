<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Route;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        $requests = Route::all();

        return view('drivers.index',['drivers'=>$drivers, 'routes' => $requests]);

    }
    public function create()
    {
        return view('drivers.create');
    }


    public function delete(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index');
    }

    public function store(Request $request)
    {
        $request = Driver::create([
            'name' => $request->input('name'),
            'phone'=>$request->input('phone'),
            'vehicle'=>$request->input('vehicle'),
            'password'=>$request->input('password'),
            'username'=>$request->input('username'),
        ]);

        return redirect()->route('drivers.index');
    }
}
