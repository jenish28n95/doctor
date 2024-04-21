<?php

namespace App\Http\Controllers;

use App\Models\Shortcode;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;

class AdminShortCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shortcodes = Shortcode::get();
        return view('admin.shortcode.index', compact('shortcodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shortcode.create');
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
            'code' => 'required|string|min:4|max:4',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        Shortcode::create($request->all());

        return redirect('admin/short_code')->with('success', "Add Record Successfully");
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
        $shortcode = Shortcode::findOrFail($id);
        return view('admin.shortcode.edit', compact('shortcode'));
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
            'code' => 'required|string|min:4|max:4',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        $shortcode = Shortcode::findOrFail($id);
        $input = $request->all();
        $shortcode->update($input);
        return redirect('admin/short_code')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shortcode = Shortcode::findOrFail($id);
        $shortcode->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }

    public function suggestion(Request $request)
    {
        $content = preg_replace('/<\/p>/', '', $request->input('search_term'));
        $data = Shortcode::where('code', $content)->get();
        return response()->json(['suggestion' => $data]);
    }
}
