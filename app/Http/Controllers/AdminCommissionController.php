<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\Financialyear;
use Carbon\Carbon;
use PDF;

class AdminCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $f_years = Financialyear::get();
        $doctors = Doctor::where('name', '!=', 'self')->get();
        $data = [];
        $wallet = Wallet::query();
        if ($request->has('date_range')) {
            $dateRange = $request->input('date_range');
            $select_doctor = $request->input('doctor');
            if ($select_doctor == 'all') {
                switch ($dateRange) {
                    case 'today':
                        $wallet->whereDate('created_at', Carbon::today());
                        break;
                    case 'yesterday':
                        $wallet->whereDate('created_at', Carbon::yesterday());
                        break;
                    case 'this_week':
                        $startOfWeek = Carbon::now()->startOfWeek();
                        $endOfWeek = Carbon::now()->endOfWeek();
                        $wallet->whereDate('created_at', '>=', $startOfWeek)->whereDate('created_at', '<=', $endOfWeek);
                        break;
                    case 'this_month':
                        $startOfMonth = Carbon::now()->startOfMonth();
                        $endOfMonth = Carbon::now()->endOfMonth();
                        // $patient->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                        $wallet->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth);
                        break;
                    case 'custom_month':
                        $startMonth = $request->start_date;
                        $endMonth = $request->end_date;
                        // $patient->whereBetween('created_at', [$startMonth, $endMonth]);
                        $wallet->whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $endMonth);
                        break;
                    case 'custom_year':
                        $wallet->where('f_year', $request->select_year);
                        break;
                    default:
                        // Handle invalid date range
                        return redirect()->back()->with('error', "Please select a valid date range");
                }
            } else {
                switch ($dateRange) {
                    case 'today':
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', Carbon::today());
                        break;
                    case 'yesterday':
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', Carbon::yesterday());
                        break;
                    case 'this_week':
                        $startOfWeek = Carbon::now()->startOfWeek();
                        $endOfWeek = Carbon::now()->endOfWeek();
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', '>=', $startOfWeek)->whereDate('created_at', '<=', $endOfWeek);
                        break;
                    case 'this_month':
                        $startOfMonth = Carbon::now()->startOfMonth();
                        $endOfMonth = Carbon::now()->endOfMonth();
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth);
                        break;
                    case 'custom_month':
                        $startMonth = $request->start_date;
                        $endMonth = $request->end_date;
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $endMonth);
                        break;
                    case 'custom_year':
                        $wallet->where('doctors_id', $select_doctor)->where('f_year', $request->select_year);
                        break;
                    default:
                        // Handle invalid date range
                        return redirect()->back()->with('error', "Please select a valid date range");
                }
            }

            $data = $wallet->get();
            $data_count = $wallet->count();
            if (isset($data) && $data_count != 0) {
                return view('admin.commission.index', compact('doctors', 'f_years', 'data'));
            }
            return redirect()->back()->with('success', "0 Record found");
        }
        return view('admin.commission.index', compact('doctors', 'f_years', 'data'));
    }

    public function download(Request $request)
    {
        $f_years = Financialyear::get();
        $doctors = Doctor::where('name', '!=', 'self')->get();
        $data = [];
        $wallet = Wallet::query();
        if ($request->has('date_range')) {
            $dateRange = $request->input('date_range');
            $select_doctor = $request->input('doctor');
            if ($select_doctor == 'all') {
                switch ($dateRange) {
                    case 'today':
                        $wallet->whereDate('created_at', Carbon::today());
                        $period = Carbon::today()->format('j F Y');
                        break;
                    case 'yesterday':
                        $wallet->whereDate('created_at', Carbon::yesterday());
                        $period = Carbon::yesterday()->format('j F Y');
                        break;
                    case 'this_week':
                        $startOfWeek = Carbon::now()->startOfWeek();
                        $endOfWeek = Carbon::now()->endOfWeek();
                        $wallet->whereDate('created_at', '>=', $startOfWeek)->whereDate('created_at', '<=', $endOfWeek);

                        $startDay = $startOfWeek->format('d');
                        $endDay = $endOfWeek->format('d');
                        $month = $startOfWeek->format('F');
                        $year = $startOfWeek->format('Y');

                        $period = "$startDay $month $year - $endDay $month $year";

                        break;
                    case 'this_month':
                        $startOfMonth = Carbon::now()->startOfMonth();
                        $endOfMonth = Carbon::now()->endOfMonth();
                        $wallet->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth);

                        $month = $startOfMonth->format('F');
                        $year = $startOfMonth->format('Y');

                        $period = "$month $year";

                        break;
                    case 'custom_month':
                        $startMonth = $request->start_date;
                        $endMonth = $request->end_date;
                        $wallet->whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $endMonth);

                        $start = Carbon::parse($request->start_date)->format('j F Y');
                        $end = Carbon::parse($request->end_date)->format('j F Y');

                        $period = "$start - $end";

                        break;
                    case 'custom_year':
                        $wallet->where('f_year', $request->select_year);

                        $year = $request->select_year;

                        $period = "$year";
                        break;
                    default:
                        // Handle invalid date range
                        return redirect()->back()->with('error', "Please select a valid date range");
                }
            } else {
                switch ($dateRange) {
                    case 'today':
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', Carbon::today());
                        $period = Carbon::today()->format('j F Y');
                        break;
                    case 'yesterday':
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', Carbon::yesterday());
                        $period = Carbon::yesterday()->format('j F Y');
                        break;
                    case 'this_week':
                        $startOfWeek = Carbon::now()->startOfWeek();
                        $endOfWeek = Carbon::now()->endOfWeek();
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', '>=', $startOfWeek)->whereDate('created_at', '<=', $endOfWeek);

                        $startDay = $startOfWeek->format('d');
                        $endDay = $endOfWeek->format('d');
                        $month = $startOfWeek->format('F');
                        $year = $startOfWeek->format('Y');

                        $period = "$startDay $month $year - $endDay $month $year";

                        break;
                    case 'this_month':
                        $startOfMonth = Carbon::now()->startOfMonth();
                        $endOfMonth = Carbon::now()->endOfMonth();
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth);

                        $month = $startOfMonth->format('F');
                        $year = $startOfMonth->format('Y');

                        $period = "$month $year";

                        break;
                    case 'custom_month':
                        $startMonth = $request->start_date;
                        $endMonth = $request->end_date;
                        $wallet->where('doctors_id', $select_doctor)->whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $endMonth);

                        $start = Carbon::parse($request->start_date)->format('j F Y');
                        $end = Carbon::parse($request->end_date)->format('j F Y');

                        $period = "$start - $end";

                        break;
                    case 'custom_year':
                        $wallet->where('doctors_id', $select_doctor)->where('f_year', $request->select_year);

                        $year = $request->select_year;

                        $period = "$year";
                        break;
                    default:
                        // Handle invalid date range
                        return redirect()->back()->with('error', "Please select a valid date range");
                }
            }


            $data = $wallet->get();
            $data_count = $wallet->count();

            if (isset($data) && $data_count != 0) {
                if ($request->input('report') == 'summary') {
                    if ($request->input('doctor') == 'all') {
                        $doctors = Doctor::get();
                    } else {
                        $doctors = Doctor::where('id', $select_doctor)->get();
                    }
                    $pdf = PDF::loadView('admin.commission.summarypdf', compact('doctors', 'f_years', 'data', 'period'));
                }
                if ($request->input('report') == 'detail') {
                    if ($request->input('doctor') == 'all') {
                        $doctors = Doctor::get();
                    } else {
                        $doctors = Doctor::where('id', $select_doctor)->get();
                    }
                    $pdf = PDF::loadView('admin.commission.detailpdf', compact('doctors', 'f_years', 'data', 'period'));
                }

                return $pdf->download($select_doctor . '-report.pdf');
            }
            return redirect()->back()->with('success', "0 Record found");
        } else {
            return redirect()->back()->with('error', "Please select valid options");
        }
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
        //
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
