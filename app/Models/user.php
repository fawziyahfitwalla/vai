<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    use HasFactory;

    protected $table='users';
    protected $fillable=['name','email','user_type'];
    protected $hidden=['password'];

    public function appointments()
    {
        return $this->hasMany(getAppointments::class, 'id', 'patient_id');
    }

    public function doctors()
    {
        //return $this->hasOne('do');
    }
}
