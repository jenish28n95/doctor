<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Rtype;
use App\Models\Childrtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminChildReportTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $childrtypes = Childrtype::orderBy('id', 'DESC')->get();
        return view('admin.child_report_types.index', compact('childrtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rtypes = Rtype::get();
        return view('admin.child_report_types.create', compact('rtypes'));
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
            'rtypes_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        // $childrtype = Childrtype::create($request->all());

        $childrtype = Childrtype::create([
            'rtypes_id' => $request->rtypes_id,
            'name' => $request->name,
            'amount' => $request->amount,
        ]);

        $directoryPath = public_path('reports/' . $request->rtypes_id . '/' . $childrtype->id);
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        if ($file = $request->file('file')) {

            $str = $file->getClientOriginalName();
            $str = str_replace(' ', '_', $str);

            $name = $str;

            $file->move($directoryPath, $name);
        }

        return redirect('admin/child_report_types')->with('success', "Add Record Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rtypes = Rtype::get();
        $childrtype = Childrtype::findOrFail($id);
        return view('admin.child_report_types.edit', compact('rtypes', 'childrtype'));
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
            'rtypes_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        $childrtype = Childrtype::findOrFail($id);
        $input = $request->all();
        // $childrtype->update($input);

        $childrtype->update([
            'rtypes_id' => $input['rtypes_id'],
            'name' => $input['name'],
            'amount' => $input['amount'],
        ]);

        $directoryPath = public_path('reports/' . $childrtype->rtypes_id . '/' . $childrtype->id);
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        if ($file = $request->file('file')) {

            $str = $file->getClientOriginalName();
            $str = str_replace(' ', '_', $str);

            $name = $str;

            $file->move($directoryPath, $name);
        }

        return redirect('admin/child_report_types')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $childrtype = Childrtype::findOrFail($id);
        $childrtype->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }
}
