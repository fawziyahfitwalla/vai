<?php

namespace App\Classes;

use App\Models\appointments;
use http\Env\Request;
use Illuminate\Support\Facades\DB;

class appointmentClass
{
    protected $appointments;
    public function __construct(appointments $appointments)
    {
        $this->appointments=$appointments;
    }

    public function makeAppointment($appointment_array)
    {
        //print_r($appointment_array); die;
        $this->appointments->doctor_id=$appointment_array['doctor_id'];
        $this->appointments->patient_id=$appointment_array['patient_id'];
        $this->appointments->appointment_time=$appointment_array['appointment_time'];
        $this->appointments->status=$appointment_array['status'];
        $this->appointments->save();
        return $this->appointments->id;
    }

    public function changeAppointmentStatus($appointment_id,$status)
    {
        $appt=appointments::find($appointment_id);
        $appt->status=$status;
        $appt->save();
    }

    public function updateAppointment($appointment_array)
    {
        $appt=appointments::find($appointment_array['appointment_id']);
        $appt->doctor_id=$appointment_array['doctor_id'];
        $appt->appointment_time=$appointment_array['appointment_time'];
        $appt->status=$appointment_array['status'];
        $appt->save();
    }

    public function getAppointmentHistory($patient_id,$email)
    {
        $res=user::with('appointments')->where('patient_id',$patient_id);
    }

    public function checkAppointmentStatus($appointment_id)
    {
        $appt=appointments::find($appointment_id);
        if($appt)
        {
            return $appt->status;
        }
        return 0;
    }
    public function getAppointmentsByDate($date)
    {
        $res=appointments::whereDate('appointment_time', '=', $date)->get();
        return ($res->toArray());
    }

    public function getAppointments()
    {
        $res=appointments::with('users')->with('doctors')->get();
        return ($res->toArray());
    }

    public function getDoctorsAppointments($user_id)
    {

        $res=appointments::with('users')->where('doctor_id',$user_id)->get();
        return ($res->toArray());
    }

    public function getPatientsAppointments($user_id)
    {

        $res=appointments::with('doctors')->where('patient_id',$user_id)->get();
        return ($res->toArray());
    }
}
