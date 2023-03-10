<?php

namespace App\Http\Controllers;

use App\Classes\appointmentClass;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;


class MainController extends Controller
{
    protected $appointmentClass;
    public function __construct(appointmentClass $appointmentClass)
    {
        $this->appointmentClass=$appointmentClass;
    }

    public function index()
    {
        return view('login');
    }
    function registration()
    {
        return view('registration');
    }

    function validate_registration(Request $request)
    {
        $request->validate([
            'name'         =>   'required',
            'email'        =>   'required|email|unique:users',
            'password'     =>   'required|min:6'
        ]);

        $data = $request->all();

        User::create([
            'name'  =>  $data['name'],
            'email' =>  $data['email'],
            'user_type'=> 2,
            'password' => Hash::make($data['password'])
        ]);

        return redirect('login')->with('success', 'Registration Completed, now you can login');
    }

    function validate_login(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials))
        {

            $auth_user=(Auth::user()->toArray());

            $request->session()->put('user_type',$auth_user['user_type']);
            $request->session()->put('user_id',$auth_user['id']);

            return redirect('dashboard');
        }

        return redirect('login')->with('success', 'Login details are not valid');
    }

    function dashboard()
    {
        if(Auth::check())
        {
            $user_type=session('user_type');
            if($user_type==0)
                $appts=$this->appointmentClass->getAppointments();
            else if($user_type==1)
                $appts=$this->appointmentClass->getDoctorsAppointments(session('user_id'));
            else
                $appts=$this->appointmentClass->getPatientsAppointments(session('user_id'));
            return view('dashboard', ['appointments'=>$appts]);
        }

        return redirect('login')->with('success', 'you are not allowed to access');
    }

    function logout()
    {
        Session::flush();

        Auth::logout();

        return Redirect('login');
    }
}
