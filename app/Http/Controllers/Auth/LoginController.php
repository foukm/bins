<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    //
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'donor') {
            return redirect('/welcome'); // Ανακατεύθυνση για "donor"
        }

        return redirect('/home'); // Γενική ανακατεύθυνση για άλλους ρόλους
    }
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|string', // Έλεγχος ρόλου
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            // Check user role
            if ($user->role == $request->role) {
                // Authentication passed and role is correct
                return redirect()->intended('/home'); // Προσαρμόστε τη διεύθυνση
            } else {
                // Wrong role
                Auth::logout();
                return back()->withErrors(['role' => 'The provided role is incorrect.']);
            }
        }
        
        // If authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
