<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use PDF;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Financialyear;
use App\Models\Patientreport;
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

    public function dashboard(Request $request)
    {
        $f_year = Session::get('setfinancialyear');
        $docotr_count = Doctor::count();
        $today_patient_count = Patient::where('f_year', $f_year)->whereDate('created_at', Carbon::today())->count();
        $total_patient_count = Patient::where('f_year', $f_year)->count();
        $current_month_patient_count = Patient::where('f_year', $f_year)->whereMonth('created_at', Carbon::now()->month)->count();

        $currentMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        if (isset($request->custom_month)) {

            $selectedMonth = $request->custom_month;
            [$monthName, $year] = explode('-', $selectedMonth);

            $monthMap = [
                'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4,
                'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8,
                'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12
            ];

            $month = $monthMap[$monthName];

            $currentMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        }

        // $lastMonth  = Carbon::now()->subMonth()->startOfMonth();
        // $endOfLastMonth  = Carbon::now()->subMonth()->endOfMonth();

        $patientCounts = Patient::whereBetween('created_at', [$currentMonth, $endOfMonth])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d'); // Group by day
            })
            ->map(function ($item) {
                return count($item); // Count patients for each day
            });

        $dates = [];
        $patientNumbers = [];

        // Fill in missing dates with 0
        for ($date = $currentMonth; $date <= $endOfMonth; $date->addDay()) {
            $day = $date->format('d');
            $dates[] = $day;
            $patientNumbers[] = $patientCounts[$day] ?? 0;
        }

        list($start_year, $end_year) = explode('-', $f_year);

        $start_date = Carbon::create($start_year, 4, 1);
        $end_date = Carbon::now()->endOfMonth();
        $period = $start_date->monthsUntil($end_date);

        $monthlist = [];
        foreach ($period->toArray() as $date) {
            $monthlist[] = [
                'month' => Carbon::parse($date)->shortMonthName,
                'year' => Carbon::parse($date)->year,
            ];
        }
        $monthlist = array_reverse($monthlist);

        $financialYearStart = Carbon::createFromDate($start_year, 4, 1)->startOfMonth();
        $financialYearEnd = Carbon::createFromDate($end_year, 3, 31)->endOfMonth();

        $patientCounts = Patient::whereBetween('created_at', [$financialYearStart, $financialYearEnd])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('M'); // Group by month
            })
            ->map(function ($item) {
                return count($item); // Count patients for each month
            });

        $months = [];
        $monthpatientNumbers = [];

        // Get list of months in the financial year
        $currentMonth = $financialYearStart->copy();
        while ($currentMonth <= $financialYearEnd) {
            $months[] = $currentMonth->format('M');
            $monthpatientNumbers[] = $patientCounts[$currentMonth->format('M')] ?? 0;
            $currentMonth->addMonth();
        }

        $financialYearStart = Carbon::createFromDate($start_year, 4, 1)->startOfMonth();
        $financialYearEnd = Carbon::createFromDate($end_year, 3, 31)->endOfMonth();

        // Fetch sonography reports count for each month
        $sonographyCounts = Patientreport::where('report_id', 3)
            ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('M'); // Group by month
            })
            ->map(function ($item) {
                return count($item); // Count sonography reports for each month
            });

        // Fetch x-ray reports count for each month
        $xrayCounts = Patientreport::where('report_id', 4)
            ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('M'); // Group by month
            })
            ->map(function ($item) {
                return count($item); // Count x-ray reports for each month
            });

        // Fetch color-doppler reports count for each month
        $dopplerCounts = Patientreport::where('report_id', 2)
            ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('M'); // Group by month
            })
            ->map(function ($item) {
                return count($item); // Count color-doppler reports for each month
            });

        $months = [];
        $sonographyNumbers = [];
        $xrayNumbers = [];
        $dopplerNumbers = [];

        // Get list of months in the financial year
        $currentMonth = $financialYearStart->copy();
        while ($currentMonth <= $financialYearEnd) {
            $months[] = $currentMonth->format('M');
            $sonographyNumbers[] = $sonographyCounts[$currentMonth->format('M')] ?? 0;
            $xrayNumbers[] = $xrayCounts[$currentMonth->format('M')] ?? 0;
            $dopplerNumbers[] = $dopplerCounts[$currentMonth->format('M')] ?? 0;
            $currentMonth->addMonth();
        }


        return view('admin.index', compact('docotr_count', 'today_patient_count', 'current_month_patient_count', 'total_patient_count', 'dates', 'patientNumbers', 'months', 'monthpatientNumbers', 'sonographyNumbers', 'xrayNumbers', 'dopplerNumbers', 'monthlist'));
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

    public function investigation(Request $request)
    {
        $f_year = Session::get('setfinancialyear');
        list($start_year, $end_year) = explode('-', $f_year);

        $start_date = Carbon::create($start_year, 4, 1);

        $end_date = Carbon::now()->endOfMonth();

        $period = $start_date->monthsUntil($end_date);

        list($start_year, $end_year) = explode('-', $f_year);

        $monthlist = [];
        foreach ($period->toArray() as $date) {
            $monthlist[] = [
                'month' => Carbon::parse($date)->shortMonthName,
                'year' => Carbon::parse($date)->year,
            ];
        }

        $monthlist = array_reverse($monthlist); // Reverse the array

        $months = [];
        $monthpatientNumbers = [];

        if ($request->has('ref_doctor') && $request->ref_doctor != 'all') {

            $financialYearStart = Carbon::createFromDate($start_year, 4, 1)->startOfMonth();
            $financialYearEnd = Carbon::createFromDate($end_year, 3, 31)->endOfMonth();

            $patientCounts = Patient::where('doctors_id', $request->ref_doctor)->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('M'); // Group by month
                })
                ->map(function ($item) {
                    return count($item); // Count patients for each month
                });

            $currentMonth = $financialYearStart->copy();
            while ($currentMonth <= $financialYearEnd) {
                $months[] = $currentMonth->format('M');
                $monthpatientNumbers[] = $patientCounts[$currentMonth->format('M')] ?? 0;
                $currentMonth->addMonth();
            }
        }

        $f_years = Financialyear::get();
        $doctors = Doctor::all();

        return view('admin.investigation.index', compact('f_years', 'monthlist', 'doctors', 'months', 'monthpatientNumbers'));
    }

    public function viewInvestigationPDF(Request $request)
    {
        $PatientQuery = Patient::query();
        if ($request->has('date_range')) {
            $dateRange = $request->input('date_range');
            switch ($dateRange) {
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
                    $PatientQuery->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth);
                    $name = $selectedMonth;
                    break;
                case 'custom_month':
                    $startMonth = $request->start_date;
                    $endMonth = $request->end_date;
                    $PatientQuery->whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $endMonth);
                    $s_date = Carbon::parse($startMonth)->format('d/m/Y');
                    $e_date = Carbon::parse($endMonth)->format('d/m/Y');
                    $name = $s_date . ' To ' . $e_date;
                    break;
                case 'custom_year':
                    $PatientQuery->whereYear('created_at', $request->select_year);
                    $year = $request->select_year;

                    $data = $PatientQuery->orderBy('created_at', 'asc')
                        ->get()
                        ->groupBy(function ($item) {
                            return Carbon::parse($item->created_at)->format('F Y');
                        });

                    $data_count = count($data);
                    if ($data_count != 0) {
                        $pdf = PDF::loadView('admin.investigation.monthlypdf', compact('data'));
                        $pdfContent = $pdf->output();

                        return response($pdfContent)
                            ->header('Content-Type', 'application/pdf')
                            ->header('Content-Disposition', 'inline; filename="monthly_report.pdf"');
                    }

                    return redirect()->back()->with('success', "0 Record found");

                    $zipName = "Financial year $year";

                    break;
                default:
                    // Handle invalid date range
                    return redirect()->back()->with('error', "Please select a valid date range");
            }
            $data = $PatientQuery->orderBy('created_at', 'asc')
                ->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->created_at)->format('d/m/Y');
                });

            $data_count = count($data);
            if (isset($data) && $data_count != 0) {
                $pdf = PDF::loadView('admin.investigation.datewisepdf', compact('data', 'name'));
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


    public function downloadInvestigationPDF(Request $request)
    {
        $PatientQuery = Patient::query();
        if ($request->has('date_range')) {
            $dateRange = $request->input('date_range');
            switch ($dateRange) {
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
                    $PatientQuery->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth);
                    $name = $selectedMonth;
                    break;
                case 'custom_month':
                    $startMonth = $request->start_date;
                    $endMonth = $request->end_date;
                    $PatientQuery->whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $endMonth);
                    $s_date = Carbon::parse($startMonth)->format('d/m/Y');
                    $e_date = Carbon::parse($endMonth)->format('d/m/Y');
                    $name = $s_date . ' To ' . $e_date;
                    break;
                case 'custom_year':
                    $PatientQuery->whereYear('created_at', $request->select_year);
                    $year = $request->select_year;

                    $data = $PatientQuery->orderBy('created_at', 'asc')
                        ->get()
                        ->groupBy(function ($item) {
                            return Carbon::parse($item->created_at)->format('F Y');
                        });

                    $data_count = count($data);
                    if ($data_count != 0) {
                        $pdf = PDF::loadView('admin.investigation.monthlypdf', compact('data'));

                        $zipName = "Financial year $year";

                        return $pdf->download($zipName . '.pdf');
                        // $pdfContent = $pdf->output();

                        // return response($pdfContent)
                        //     ->header('Content-Type', 'application/pdf')
                        //     ->header('Content-Disposition', 'inline; filename="monthly_report.pdf"');
                    }

                    break;
                default:
                    // Handle invalid date range
                    return redirect()->back()->with('error', "Please select a valid date range");
            }
            $data = $PatientQuery->orderBy('created_at', 'asc')
                ->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->created_at)->format('d/m/Y');
                });

            $data_count = count($data);
            if (isset($data) && $data_count != 0) {
                $pdf = PDF::loadView('admin.investigation.datewisepdf', compact('data', 'name'));

                return $pdf->download($name . '.pdf');
                // $pdfContent = $pdf->output();

                // return response($pdfContent)
                //     ->header('Content-Type', 'application/pdf')
                //     ->header('Content-Disposition', 'inline; filename="preview.pdf"');
            }
            return redirect()->back()->with('success', "0 Record found");
        } else {
            return redirect()->back()->with('error', "Please select valid options");
        }
        return redirect()->back()->with('success', "0 Record found");
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
