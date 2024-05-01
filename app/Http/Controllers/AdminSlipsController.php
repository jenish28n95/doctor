<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use PDF;
use App\Models\Slip;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Financialyear;
use App\Models\Patientreport;
use Illuminate\Support\Facades\Session;

class AdminSlipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $today = Carbon::today();
        $patients_slips = Patient::whereDate('created_at', $today)->where('is_slip', 1)->get();
        $patients_no_slips = Patient::whereDate('created_at', $today)->where('is_slip', 0)->get();
        // $f_year = Financialyear::get();
        $f_year = Session::get('setfinancialyear');
        $slipstable = Slip::whereDate('date', $today)->get();

        if (isset($request->selectdate)) {
            if (isset($request->select_patient) && isset($request->deselect_patient)) {
                $patient = Patient::where('id', $request->select_patient)->first();
                $fileNames = [];
                $get_last_slip = Slip::where('patients_id', $request->deselect_patient)->first();

                if (empty($get_last_slip)) {
                    // $get_last_slip = Slip::where('patients_id', $request->select_patient)->first();
                } else {
                    $no = $get_last_slip->sr_no;
                    $filesToDownload = [];
                    $select_patient = Patient::where('id', $request->select_patient)->update(['is_slip' => 1]);
                    $deselect_patient = Patient::where('id', $request->deselect_patient)->update(['is_slip' => 0]);
                    $patientreports = Patientreport::where('patients_id', $request->select_patient)->get();

                    $pdf = PDF::loadView('admin.patients.slipe', compact('patient', 'patientreports', 'no'));

                    $fileName = $get_last_slip->sr_no . '-' . str_replace(' ', '-', $patient->name) . '.pdf';
                    $pdf->save(public_path('slipe/') . $fileName);

                    $filePath = public_path('slipe/') . $fileName;
                    $filesToDownload[] = $filePath;
                    if (file_exists(public_path('slipe/') . $get_last_slip->file)) {
                        unlink(public_path('slipe/') . $get_last_slip->file);
                    }
                    Slip::where('id', $get_last_slip->id)
                        ->update(['file' => $fileName, 'patients_id' => $request->select_patient]);
                }

                $patients_slips = Patient::whereDate('created_at', $request->selectdate)->where('is_slip', 1)->get();
                $patients_no_slips = Patient::whereDate('created_at', $request->selectdate)->where('is_slip', 0)->get();
            } elseif (isset($request->select_patient)) {
                return redirect()->back()->with('error', "Please Deselect patient select");
                // $patient = Patient::where('id', $request->select_patient)->first();
                // if ($patient->created_at->startOfDay()->equalTo(Carbon::today())) {
                //     $get_last_slip = Slip::where('f_year', $f_year)->orderBy('id', 'DESC')->first();
                //     $no = 1;
                //     if (isset($get_last_slip)) {
                //         $no = ($get_last_slip->sr_no) + 1;
                //     }
                //     $no = str_pad($no, 4, '0', STR_PAD_LEFT);
                //     $select_patient = Patient::where('id', $request->select_patient)->update(['is_slip' => 1]);
                //     $patientreports = Patientreport::where('patients_id', $request->select_patient)->get();

                //     $pdf = PDF::loadView('admin.patients.slipe', compact('patient', 'patientreports', 'no'));

                //     $fileName = $no . '-' . str_replace(' ', '-', $patient->name) . '.pdf';
                //     $pdf->save(public_path('slipe/') . $fileName);

                //     $filePath = public_path('slipe/') . $fileName;

                //     $slip = new Slip;
                //     $slip->patients_id = $patient->id;
                //     $slip->sr_no = $no;
                //     $slip->date = $patient->created_at;
                //     $slip->file = $fileName;
                //     $slip->f_year = $f_year;
                //     $slip->save();

                //     $patients_slips = Patient::whereDate('created_at', $request->selectdate)->where('is_slip', 1)->get();
                //     $patients_no_slips = Patient::whereDate('created_at', $request->selectdate)->where('is_slip', 0)->get();
                // } else {
                //     return redirect()->back()->with('error', "Please Deselect patient select");
                // }
            } else {
                $patients_slips = Patient::whereDate('created_at', $request->selectdate)->where('is_slip', 1)->get();
                $patients_no_slips = Patient::whereDate('created_at', $request->selectdate)->where('is_slip', 0)->get();
            }
            $slipstable = Slip::whereDate('date', $request->selectdate)->get();
        }

        return view('admin.slip.edit', compact('f_year', 'patients_slips', 'patients_no_slips', 'slipstable'));
    }


    public function indexSummary(Request $request)
    {
        $f_year = Session::get('setfinancialyear');
        list($start_year, $end_year) = explode('-', $f_year);

        $start_date = Carbon::create($start_year, 4, 1);

        $end_date = Carbon::now()->endOfMonth();

        $period = $start_date->monthsUntil($end_date);

        // $period = Carbon::now()->subMonths(12)->monthsUntil(Carbon::now());

        $monthlist = [];
        foreach ($period->toArray() as $date) {
            $monthlist[] = [
                'month' => Carbon::parse($date)->shortMonthName,
                'year' => Carbon::parse($date)->year,
            ];
        }

        $monthlist = array_reverse($monthlist); // Reverse the array

        $f_years = Financialyear::get();
        return view('admin.slip.summary', compact('f_years', 'monthlist'));
    }

    public function viewSummarySlipPdf(Request $request)
    {
        $slip = Slip::query();
        if ($request->has('date_range')) {
            $dateRange = $request->input('date_range');
            switch ($dateRange) {
                case 'today':
                    $slip->whereDate('date', Carbon::today());
                    break;
                case 'on_date':
                    $ondate = $request->on_date;
                    $slip->whereDate('date', $ondate);
                    break;
                case 'yesterday':
                    $slip->whereDate('date', Carbon::yesterday());
                    break;
                case 'this_week':
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $slip->whereDate('date', '>=', $startOfWeek)->whereDate('date', '<=', $endOfWeek);
                    break;
                case 'this_month':
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now()->endOfMonth();
                    $slip->whereDate('date', '>=', $startOfMonth)->whereDate('date', '<=', $endOfMonth);
                    break;
                case 'month':
                    $selectedMonth = $request->input('custom_month_dropdown');
                    [$monthName, $year] = explode('-', $selectedMonth);

                    $monthMap = [
                        'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4,
                        'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8,
                        'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12
                    ];

                    $month = $monthMap[$monthName];

                    $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                    $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
                    $slip->whereDate('date', '>=', $startOfMonth)->whereDate('date', '<=', $endOfMonth);
                    break;
                case 'custom_month':
                    $startMonth = $request->start_date;
                    $endMonth = $request->end_date;
                    $slip->whereDate('date', '>=', $startMonth)->whereDate('date', '<=', $endMonth);
                    break;
                case 'custom_year':
                    $slip->where('f_year', $request->select_year);

                    $year = $request->select_year;

                    $zipName = "Financial year $year";

                    break;
                default:
                    // Handle invalid date range
                    return redirect()->back()->with('error', "Please select a valid date range");
            }
            $data = $slip->orderBy('date', 'asc')
                ->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->date)->format('Y-m-d');
                });

            $data_count = count($data);
            if (isset($data) && $data_count != 0) {
                $pdf = PDF::loadView('admin.backup.slippdf', compact('data'));
                // return $pdf->download($request->date_range . '-slip.pdf');

                $pdfContent = $pdf->output();
                return response($pdfContent)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="preview.pdf"');
            }
            return redirect()->back()->with('success', "0 Record found");
        } else {
            return redirect()->back()->with('error', "Please select valid options");
        }
        return redirect()->back()->with('success', "0 Record found");
    }

    public function downloadSummarySlipPdf(Request $request)
    {
        $slip = Slip::query();
        if ($request->has('date_range')) {
            $dateRange = $request->input('date_range');
            switch ($dateRange) {
                case 'today':
                    $slip->whereDate('date', Carbon::today());
                    $zipName = 'today_' . Carbon::today()->format('Ymd');
                    break;
                case 'on_date':
                    $ondate = $request->on_date;
                    $slip->whereDate('date', $ondate);
                    $zipName = 'onDay_' . $ondate;
                    break;
                case 'yesterday':
                    $slip->whereDate('date', Carbon::yesterday());
                    $zipName = 'yesterday_' . Carbon::yesterday()->format('Ymd');
                    break;
                case 'this_week':
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $slip->whereDate('date', '>=', $startOfWeek)->whereDate('date', '<=', $endOfWeek);

                    $startDay = $startOfWeek->format('d');
                    $endDay = $endOfWeek->format('d');
                    $month = $startOfWeek->format('F');
                    $year = $startOfWeek->format('Y');
                    $zipName = "Week of $startDay - $endDay $month $year";

                    break;
                case 'this_month':
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now()->endOfMonth();
                    $slip->whereDate('date', '>=', $startOfMonth)->whereDate('date', '<=', $endOfMonth);

                    $month = $startOfMonth->format('F');
                    $year = $startOfMonth->format('Y');
                    $zipName = "Month of $month $year";
                    break;
                case 'month':
                    $selectedMonth = $request->input('custom_month_dropdown');
                    [$monthName, $year] = explode('-', $selectedMonth);

                    $monthMap = [
                        'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4,
                        'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8,
                        'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12
                    ];

                    $month = $monthMap[$monthName];

                    $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                    $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
                    $slip->whereDate('date', '>=', $startOfMonth)->whereDate('date', '<=', $endOfMonth);

                    $month = $startOfMonth->format('F');
                    $year = $startOfMonth->format('Y');
                    $zipName = "Month of $selectedMonth";

                    break;
                case 'custom_month':
                    $startMonth = $request->start_date;
                    $endMonth = $request->end_date;
                    $slip->whereDate('date', '>=', $startMonth)->whereDate('date', '<=', $endMonth);

                    $start = Carbon::parse($request->start_date)->format('Ymd');
                    $end = Carbon::parse($request->end_date)->format('Ymd');
                    $zipName = "$start $end";
                    break;
                case 'custom_year':
                    $slip->where('f_year', $request->select_year);
                    $year = $request->select_year;

                    $zipName = "Financial year $year";
                    break;
                default:
                    // Handle invalid date range
                    return redirect()->back()->with('error', "Please select a valid date range");
            }
            $data = $slip->orderBy('date', 'asc')
                ->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->date)->format('Y-m-d');
                });

            $data_count = count($data);
            if (isset($data) && $data_count != 0) {

                $tempDir = 'D:/slip-backup/' . $zipName;
                if (!file_exists($tempDir)) {
                    mkdir($tempDir, 0777, true);
                }

                $pdfFilePath = $tempDir . '/' . $request->date_range . '-slip.pdf';
                $pdf = PDF::loadView('admin.backup.slippdf', compact('data'));
                $pdf->save($pdfFilePath);

                return redirect()->back()->with('success', "Slip Record save in D:/slip-backup folder");
                // return response()->json(['success' => true, 'file_path' => $pdfFilePath]);
                // return response()->download($pdfFilePath)->deleteFileAfterSend(true);
            }
            return redirect()->back()->with('success', "0 Record found");
        } else {
            return redirect()->back()->with('error', "Please select valid options");
        }
        return redirect()->back()->with('success', "0 Record found");
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
