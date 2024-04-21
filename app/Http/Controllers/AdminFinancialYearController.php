<?php

namespace App\Http\Controllers;

use App\Models\Financialyear;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;

class AdminFinancialYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $financialyears = Financialyear::orderBy('id', 'DESC')->paginate(10);
        return view('admin.financial.index', compact('financialyears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.financial.create');
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
            'year' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        Financialyear::create($request->all());

        return redirect('admin/financial_year')->with('success', "Add Record Successfully");
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
        $financialyear = Financialyear::findOrFail($id);
        return view('admin.financial.edit', compact('financialyear'));
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
            'year' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        $financial = Financialyear::findOrFail($id);
        $input = $request->all();
        $financial->update($input);
        return redirect('admin/financial_year')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $financial = Financialyear::findOrFail($id);
        $financial->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }
}
