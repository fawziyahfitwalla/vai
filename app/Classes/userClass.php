<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class userClass
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user=$user;
    }

    public function addUser($data)
    {
        $this->user->name=$data['name'];
        $this->user->email=$data['email'];
        $this->user->password=$data['password'];
        $this->user->user_type=$data['userType'];
        $this->user->save();
        return $this->user->id;
    }

    public function getAllUsers()
    {
        $users=user::all();
        return ($users->toArray());
    }

    public function getUserByType($user_type)
    {
        $users=user::where('user_type',$user_type)->get();
        return($users->toArray());
    }
}
