<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        // Auto-login after registration
        auth()->login($user);

        // Role-based redirect
        return $this->redirectBasedOnRole($user);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:candidate,employer'],
            'phone' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'phone' => $data['phone'] ?? null,
            'country' => $data['country'] ?? null,
            'is_active' => true,
        ]);
    }

    protected function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case 'employer':
                return redirect()->route('employer.dashboard')
                    ->with('success', 'Welcome! Please complete your employer profile.');
            case 'candidate':
                return redirect()->route('candidate.profile.create')
                    ->with('success', 'Welcome! Please complete your candidate profile.');
            default:
                return redirect('/');
        }
    }
}
