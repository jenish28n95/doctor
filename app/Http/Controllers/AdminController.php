<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Financialyear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{

    public function login(Request $req)
    {
        // return $req->input();
        $user = User::where(['username' => $req->username])->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return redirect()->back()->with('alert', 'Username or password is not matched');
            // return "Username or password is not matched";
        } else {
            Auth::loginUsingId($user->id);
            $req->session()->put('user', $user);
            return redirect('/admin/financial-year');
            // return redirect('/admin/dashboard');
        }
    }

    public function financialYearList(Request $req)
    {
        $years = Financialyear::get();
        return view('admin.year', compact('years'));
    }

    public function setFinancialYear(Request $req)
    {
        $req->session()->put('setfinancialyear', $req->financial_year);
        return redirect('/admin/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {
        $docotr_count = Doctor::count();
        $patient_count = Patient::where('f_year', Session::get('setfinancialyear'))->whereDate('created_at', Carbon::today())->count();
        return view('admin.index', compact('docotr_count', 'patient_count'));
    }

    public function profiledit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.profile.edit', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        // $user = User::where('id',1)->first();
        // $user->password = Hash::make($request->new_password);
        // $user->save();
        // return redirect()->back()->with("success","Password changed successfully !");
        // return $request;
        $user = Session::get('user');
        if (!(Hash::check($request->get('current_password'), $user->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Session::get('user');
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return redirect()->back()->with("success", "Password changed successfully !");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
