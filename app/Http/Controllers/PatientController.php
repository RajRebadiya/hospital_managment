<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;

class PatientController extends Controller
{
    //
    public function index()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:patients|max:255',
            'phone' => 'required|min:10|max:10',
            'password' => 'required|min:8|max:10',
            'cpassword' => 'required|same:password',
            'address' => 'required',
            'gender' => 'required',
            'dob' => 'required',
        ]);

        $patient = new Patient();
        $patient->name = $request->input('name');
        $patient->email = $request->input('email');
        $patient->phone = $request->input('phone');
        $patient->password = $request->input('password');
        $patient->address = $request->input('address');
        $patient->gender = $request->input('gender');
        $patient->date_of_birth = $request->input('dob');
        $patient->save();

        if ($patient) {
            return redirect()->route('login')->with('success', 'Registration Successful');
        } else {
            return back()->with('fail', 'Something went wrong');
        }

    }
    public function login_show(Request $request)
    {

        return view('login');
    }
    public function login(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:10',
            'role' => 'required',

        ]);
        $role = $request->input('role');

        if ($role == 1) {
            $patient = Patient::where('email', $request->input('email'))->first();
            if ($patient && $patient->password == $request->input('password')) {
                $appointment = Appointment::all();
                // set email in session for use in dashboard
                $request->session()->put('email', $request->input('email'));
                // dd($request->session()->get('email'));
                return redirect()->route('patient')->with('success', 'Login Successful')->with('appointments', $appointment);
            }
        } elseif ($role == 2) {
            $doctor = Doctor::where('email', $request->input('email'))->first();
            // dd($doctor);
            if ($doctor && $doctor->password == $request->input('password')) {
                $request->session()->put('doctor_email', $request->input('email'));

                // dd('jhvuhy');
                return redirect()->route('doctor')->with('success', 'Login Successful');
            }
        } else {
            return back()->with('error', 'Something went wrong');
        }



    }




}
