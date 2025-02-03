<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class RegisterController extends Controller
{
    //


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string'], // Ρόλος
        ]);
    }

    protected function create(array $data)
{
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => $data['role'],
    ]);
}

    public function showRegistrationForm()
    {
        return view('auth.register'); // Αν χρειαστεί να δημιουργήσεις αυτή τη φόρμα
    }

    public function register(Request $request)
{
    $this->validator($request->all())->validate();

    // Δημιουργία χρήστη
    $user = $this->create($request->all());

    // Αυτόματος login του χρήστη
    Auth::login($user);

    // Ανακατεύθυνση μετά την επιτυχή εγγραφή
    return redirect()->route('home'); // ή οποιαδήποτε άλλη διαδρομή
}
}
