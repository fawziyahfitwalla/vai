<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Classes\userClass;
use Illuminate\Validation\Rule;
use Hash;

class userController extends Controller
{
    protected $userService;
    public function __construct(userClass $userService)
    {
        $this->userService=$userService;
    }

    public function addUser(Request $request)
    {

            $name=$request->name;
            $email=$request->email;
            $password=$request->password;
            $user_type=$request->user_type;
            $data=array('name'=>$name,'email'=>$email,'password'=>$password,'userType'=>$user_type);
            $validator=Validator::make($data,[
                'name'=>['required'],
                'email'=>['required','email',Rule::unique('App\Models\user','email')],
                'password'=>['required','regex:^[a-zA-Z0-9@()_\\-."\']$^'],
                'userType'=>['required',Rule::in(['0','1','2'])]
            ]);
            if($validator->fails())
            {
                $msg=$validator->messages()->first();
                return Redirect::back()->withInput($request->except('password'))->withError($msg);
                print_r($msg);
            }
            else
            {
                $data['password']=Hash::make($data['password']);
                $res=$this->userService->addUser($data);
                return redirect()->route('users.list');
            }

    }

    public function getAllUsers(Request $request)
    {
        $users=$this->userService->getAllUsers();
        /*echo '<pre>';
       print_r($users); */
        $data['title']='Users List';
        $data['users']=$users;
        return view('view_users',['title'=>'Users List','users'=>$users]);
    }

    public function getDoctors(Request $request)
    {
        $users=$this->userService->getUserByType(1);
        /*echo '<pre>';
        print_r($users); */
        $data['title']='Doctors List';
        $data['users']=$users;
        return view('view_users',['title'=>'Doctors List','users'=>$users]);
    }

    public function getPatients(Request $request)
    {
        $users=$this->userService->getUserByType(2);
        /*echo '<pre>';
        print_r($users); */
        return view('view_users',['title'=>'Patients List','users'=>$users]);
    }


}
