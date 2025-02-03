<?php

namespace App\Http\Controllers;
use App\Models\Location;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        // Επικύρωση φόρμας
        $request->validate([
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'category' => 'required|in:αλουμινιο,ξυλο,γυαλι',
        ]);

        // Αποθήκευση δεδομένων
        Location::create([
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'category' => $request->category,
        ]);

        return back()->with('success', 'Η τοποθεσία καταχωρήθηκε επιτυχώς.');
    }
}
