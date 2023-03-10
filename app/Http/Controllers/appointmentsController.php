<?php

namespace App\Http\Controllers;

use App\Classes\appointmentClass;
use App\Classes\userClass;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class appointmentsController extends Controller
{
    protected $appointmentClass, $userClass;
    public function __construct(appointmentClass $appointmentClass, userClass $userClass)
    {
        $this->appointmentClass=$appointmentClass;
        $this->userClass=$userClass;
    }

    public function makeAppointment(Request $request)
    {

        $doctor_id=$request->doctor_id;
        $patient_id=0;
        $email='';
        if($request->filled('patient_id'))
            $patient_id=$request->patient_id;
        if(session('user_type')==2)
            $patient_id=session('user_id');



        $d1=$request->date.' '.$request->time;
        $d=strtotime($d1);
        $appointment_time=date('Y-m-d H:i',$d);

        $data=array('doctor_id'=>$doctor_id,'patient_id'=>$patient_id,'email'=>$email,'appointment_time'=>$appointment_time);
        $validator=Validator::make($data,[
            'doctor_id'=>['required',Rule::exists('users','id')->where(function(Builder $query) use($doctor_id){
                return $query->where(array('user_type'=>1));
            })],
            'patient_id'=>['required',Rule::exists('users','id')->where(function(Builder $query) use($doctor_id){
                return $query->where(array('user_type'=>2));
            })],
            'appointment_time'=>['required','date','after:now']
        ]);

        if($validator->fails())
        {
            $msg=$validator->messages()->first();
            return Redirect::back()->withInput()->withError($msg);
            echo '<pre>';
            print_r($msg);
        }
        else {
            $data['status']=1;
             $appointment_id=$this->appointmentClass->makeAppointment($data);
            return redirect()->route('dashboard');
        }

    }

    public function cancelAppointment(Request $request)
    {
        if($request->filled('appointment_id'))
        {
            $appointment_id=$request->appointment_id;
            $appt_status= $this->appointmentClass->checkAppointmentStatus($appointment_id);
            if($appt_status==1)
                $res=$this->appointmentClass->changeAppointmentStatus($appointment_id,0);
            else if($appt_status==2)
                print_r('Appointment Completed');
            else if($appt_status==0)
                print_r('Appointment already cancelled');
            else
                print_r('Appointment not found');
        }
        else
        {
            print_r('Appointment id required');
        }
    }

    public function completeAppointment(Request $request)
    {
        $appointment_id=$request->appointment_id;
        $appt_status= $this->appointmentClass->checkAppointmentStatus($appointment_id);
        if($appt_status==1)
         $res=$this->appointmentClass->changeAppointmentStatus($appointment_id,2);
        else
            print_r('Appointment cancelled/completed');
    }

    public function changeAppointment(Request $request)
    {
        $appointment_id=$request->appointment_id;
        $doctor_id=$request->doctor_id;
        $appointment_time=(date('Y-m-d H:i'));
        $appointment_time=(date('2023-03-09 20:00'));
        $data=array('doctor_id'=>$doctor_id,'appointment_time'=>$appointment_time,'appointment_id'=>$appointment_id);
        $validator=Validator::make($data,[
            'appointment_id'=>['required',Rule::exists('appointments','id')->where(function(Builder $query) {
                return $query->where(array('status'=>1));
            })],
            'doctor_id'=>['required',Rule::exists('users','id')->where(function(Builder $query) use($doctor_id){
                return $query->where(array('user_type'=>1));
            })],
            'appointment_time'=>['required','date','after:now']
        ]);
        if($validator->fails())
        {
            $msg=$validator->messages()->first();
            echo '<pre>';
            print_r($msg);
        }
        else {
            $data['status']=1;
            echo $res=$this->appointmentClass->updateAppointment($data);
        }


    }

    public function makeAppointmentForm(Request $request)
    {
        $doctors=$this->userClass->getUserByType(1);
        if(session('user_type')!=2)
            $patients=$this->userClass->getUserByType(2);
        else
            $patients=array();
        return view('make_appointment', ['doctors'=>$doctors, 'patients'=>$patients]);
    }



    public function getAppointmentsByDate(Request $request)
    {

        $date=$request->year.'-'.$request->month.'-'.$request->date;
        $res=$this->appointmentClass->getAppointmentsByDate($date);
        $ret=array();
        foreach ($res as $appt)
        {
            $d=date('H:i',strtotime($appt['appointment_time']));
            $ret[]=(int) $d;
        }
        return response()->json($ret);
    }
}
