<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bin;

class BinController extends Controller
{
    public function create()
    {
        $bins = Bin::query()->select(['name','category','lan','lot'])->get();
        return view('bins.map', compact('bins'));
    }
    public function index()
    {
        $bins = Bin::all();
       return view('bins.index',['bins'=>$bins]);
       
    }

    public function delete(Bin $bin)
    {
        $bin->delete();
        return redirect()->route('bins.index');
    }

    public function store(Request $request)
    {
        $bin = Bin::create([
            'name' => $request->input('address'),
            'category'=>$request->input('category'),
            'lan' => $request->input('latitude'),
            'lot' => $request->input('longitude'),
        ]);

        return redirect()->route('locations.store');
    }

    public function destroy($id)
    {
        $bin = Bin::findOrFail($id);
        $bin->delete();

        return response()->json(['message' => 'Bin deleted'], 200);
    }
}
