<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;

class AppointmentController extends Controller
{
    //
    public function appointment_show()
    {
        // $user_id = auth()->user()->id;
        return view('appointment');
    }
    public function patient_show(Request $request)
    {
        $pateint = Patient::where('email', $request->session()->get('email'))->first();
        $appointments = Appointment::where('patient_id', $pateint->id)->get();
        return view('patient', compact('appointments'));
    }

    public function edit_show($id)
    {
        $appointment = Appointment::find($id);
        return view('edit', compact('appointment'));
    }

    public function appointment(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'app_date' => 'required',
            'app_time' => 'required',
            'doctor_id' => 'required',
        ]);

        // Check if the email exists in the session
        $patient = Patient::where('email', $request->session()->get('email'))->first();
        if (!$patient) {
            return back()->with('fail', 'Something went wrong');
        }

        $appointment = new Appointment();
        $appointment->name = $request->input('name');
        $appointment->email = $request->input('email');
        $appointment->date = $request->input('app_date');
        $appointment->time = $request->input('app_time');
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->patient_id = $patient->id;

        $appointment->save();

        if ($appointment) {
            $appointments = Appointment::all();
            return redirect()->route('patient')->with('success', 'Appointment Successful');
        } else {
            return back()->with('fail', 'Something went wrong');
        }
    }

    public function edit(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id' => 'required',
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'app_date' => 'required',
            'app_time' => 'required',
            'doctor_id' => 'required',
        ]);

        $appointment = Appointment::find($request->input('id'));
        $appointment->name = $request->input('name');
        $appointment->email = $request->input('email');
        $appointment->date = $request->input('app_date');
        $appointment->time = $request->input('app_time');
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->save();
        if ($appointment) {
            return redirect()->route('patient')->with('success', 'Appointment Successful');
        } else {
            return back()->with('fail', 'Something went wrong');
        }
    }

    public function delete($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();
        return redirect()->route('patient')->with('success', 'Appointment Deleted');
    }
}
