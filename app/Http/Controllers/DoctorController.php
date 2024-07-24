<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;

class DoctorController extends Controller
{
    //

    public function doctor(Request $request)
    {
        $doctor = Doctor::where('email', request()->session()->get('doctor_email'))->first();
        // dd($doctor->id);
        $appointments = Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->get();
        return view('doctor', compact('appointments'));
    }
    public function accept($id)
    {
        $appointment = Appointment::find($id);
        $appointment->status = 'accepted';
        $appointment->save();
        return redirect()->back()->with('success', 'Appointment Accepted');
    }

    public function reject($id)
    {
        $appointment = Appointment::find($id);
        $appointment->status = 'rejected';
        $appointment->save();
        return redirect()->back()->with('success', 'Appointment Rejected');
    }
    public function search(Request $request)
    {

        $doctorEmail = $request->session()->get('doctor_email');
        $doctor = Doctor::where('email', $doctorEmail)->first();

        $name = $request->input('name');
        $start_date = $request->input('date');
        // $end_date = $request->input('end_date');
        // dd($doctor->id);

        $query = Appointment::where('doctor_id', $doctor->id);
        // dd($query);

        if ($name != '') {
            // dd('hdd');
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($start_date != '') {
            // dd('sss');
            $query->whereDate('date', '>=', $start_date);
        }



        $appointments = $query->get();
        // dd($appointments);

        return view('doctor', compact('appointments'));
    }

}
