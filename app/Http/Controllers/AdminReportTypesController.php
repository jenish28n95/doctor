<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Rtype;
use App\Models\Childrtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminReportTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rtypes = Rtype::orderBy('id', 'DESC')->get();
        return view('admin.report_types.index', compact('rtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.report_types.create');
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
            // 'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        $rtype = Rtype::create($request->all());

        $directoryPath = public_path('reports/' . $rtype->id);
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        return redirect('admin/report_types')->with('success', "Add Record Successfully");
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
        $childrtype = Childrtype::where('rtypes_id', $id)->get();
        $rtype = Rtype::findOrFail($id);
        return view('admin.report_types.edit', compact('rtype', 'childrtype'));
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
            // 'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        $rtype = Rtype::findOrFail($id);
        $input = $request->all();
        $rtype->update($input);

        $directoryPath = public_path('reports/' . $rtype->id);
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        return redirect('admin/report_types')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rtype = Rtype::findOrFail($id);
        $rtype->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }

    public function storeDocFile(Request $request)
    {

        $directoryPath = public_path('reports/' . $request->rtype_id . '/' . $request->childreportid);

        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        if ($file = $request->file('file')) {

            $str = $file->getClientOriginalName();
            $str = str_replace(' ', '_', $str);

            $name = time() . $str;

            $file->move($directoryPath, $name);
        }

        return Redirect::back()->with('success', "Save Record Successfully");
    }
}
