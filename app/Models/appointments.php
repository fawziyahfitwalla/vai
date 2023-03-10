<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointments extends Model
{

    protected $fillable=['doctor_id','patient_id','appointment_time'];

    use HasFactory;
    public function users()
    {
        return $this->belongsTo(User::class, 'patient_id','id');
    }
    public function doctors()
    {
        return $this->belongsTo(User::class, 'doctor_id','id');
    }
}
