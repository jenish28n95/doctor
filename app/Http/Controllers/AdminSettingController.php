<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $f_setting = Setting::where('key', 'Fixed_amount')->first();
        $p_setting = Setting::where('key', 'Custom_percentage')->first();
        return view('admin.setting.index', compact('f_setting', 'p_setting'));
    }

    public function changeFyear(Request $req)
    {
        $req->session()->put('setfinancialyear', $req->financial_year);
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Setting::where('key', 'Fixed_amount')->update(['amount' => $request->f_amount, 'comm_amount' => $request->f_comm_amount]);

        $value = $request->p_comm_amount / 100;
        Setting::where('key', 'Custom_percentage')->update(['amount' => $request->f_amount, 'comm_amount' => $value]);

        return redirect('admin/setting')->with('success', "Update Record Successfully");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
