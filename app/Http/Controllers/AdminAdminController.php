<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Admin;
use App\Models\Patient;
use App\Models\Slip;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::orderBy('id', 'DESC')->get();
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        Admin::create($request->all());

        return redirect('admin/admins')->with('success', "Add Record Successfully");
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
        $admin = Admin::findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            // 'is_active' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        $admin = Admin::findOrFail($id);
        $input = $request->all();
        $admin->update($input);
        return redirect('admin/admins')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }

    public function adminActive($id)
    {
        $admin = Admin::where('id', $id)->first();
        if ($admin->is_active == 1) {
            $admin->is_active = 0;
        } else {
            $admin->is_active = 1;
        }
        $admin->save();
        return redirect()->back()->with('success', "Update Record Successfully");
    }

    public function updatewallet()
    {

        $patients = Patient::get();

        foreach ($patients as $patient) {
            Wallet::where('patients_id', $patient->id)->update(['admins_id' => $patient->admins_id]);
            Slip::where('patients_id', $patient->id)->update(['admins_id' => $patient->admins_id]);
        }

        return redirect()->back()->with('success', "Update Record Successfully");
    }

    public function updateAdminZeros()
    {
        $walletadminzeros = Wallet::where('admins_id', 0)->get();
        foreach ($walletadminzeros as $walletzero) {
            $patient = Patient::where('id', $walletzero->patients_id)->first();
            $walletzero->update(['admins_id' => $patient->admins_id]);
        }

        // $walletadminzeros = Wallet::where('admins_id', 0)
        //     ->whereHas('patient')
        //     ->get();

        // foreach ($walletadminzeros as $walletzero) {
        //     $walletzero->update(['admins_id' => $walletzero->patient->admins_id]);
        // }

        $slipadminzeros = Slip::where('admins_id', 0)->get();
        foreach ($slipadminzeros as $slipadminzero) {
            $patient = Patient::where('id', $slipadminzero->patients_id)->first();
            $slipadminzero->update(['admins_id' => $patient->admins_id]);
        }

        // $slipadminzeros = Slip::where('admins_id', 0)->whereHas('patient')->get();
        // foreach ($slipadminzeros as $slipadminzero) {
        //     $slipadminzero->update(['admins_id' => $slipadminzero->patient->admins_id]);
        // }

        return redirect()->back()->with('success', "Update Record Successfully");
    }
}
