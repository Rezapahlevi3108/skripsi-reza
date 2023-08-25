<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\KmeansController;

class UserController extends Controller
{
    protected $kmeansController;

    public function __construct(KmeansController $kmeansController)
    {
        $this->kmeansController = $kmeansController;
    }

    public function login()
    {
        return view('pages/login');
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $data = DB::table('data')->get();
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            if ($data->count() > 0 && $data->where('cluster', '!=', 0)->count() > 0){
                $request->session()->regenerate();
                $this->kmeansController->kmeans($request);
                return redirect()->intended('/home');
            } else {
                $request->session()->regenerate();
                return redirect()->intended('/home');
            }
        }

        return back()->withErrors([
            'password' => 'Username atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('kmeans_data');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register()
    {
        return view('pages/register');
    }

    public function register_action(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

        return redirect()->route('login')->with('success', 'Registration success. Please login!');
    }

    public function password()
    {
        return view('pages/password');
    }

    public function password_action(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        $request->session()->regenerate();
        return back()->with('success', 'Password changed!');
    }
}
