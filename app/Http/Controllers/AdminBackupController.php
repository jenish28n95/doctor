<?php

namespace App\Http\Controllers;

use PDF;
use ZipArchive;
use Carbon\Carbon;
use App\Models\Slip;
use App\Models\Patient;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Response;
use App\Models\Financialyear;
use App\Models\Patientreport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class AdminBackupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $f_years = Financialyear::get();
        return view('admin.backup.index', compact('f_years'));
    }

    // public function download(Request $request)
    // {
    //     $patient = Patient::query();
    //     if ($request->has('date_range')) {
    //         $dateRange = $request->input('date_range');
    //         switch ($dateRange) {
    //             case 'today':
    //                 $patient->whereDate('created_at', Carbon::today());
    //                 break;
    //             case 'yesterday':
    //                 $patient->whereDate('created_at', Carbon::yesterday());
    //                 break;
    //             case 'this_week':
    //                 $startOfWeek = Carbon::now()->startOfWeek();
    //                 $endOfWeek = Carbon::now()->endOfWeek();
    //                 $patient->whereDate('created_at', '>=', $startOfWeek)->whereDate('created_at', '<=', $endOfWeek);
    //                 break;
    //             case 'this_month':
    //                 $startOfMonth = Carbon::now()->startOfMonth();
    //                 $endOfMonth = Carbon::now()->endOfMonth();
    //                 $patient->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth);
    //                 break;
    //             case 'custom_month':
    //                 $startMonth = $request->start_date;
    //                 $endMonth = $request->end_date;
    //                 $patient->whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $endMonth);
    //                 break;
    //             case 'custom_year':
    //                 $patient->where('f_year', $request->select_year);
    //                 break;
    //             default:
    //                 // Handle invalid date range
    //                 return redirect()->back()->with('error', "Please select a valid date range");
    //         }
    //         $data = $patient->get();
    //         $list_ids = $patient->pluck('id')->toArray();

    //         $reports_list = Patientreport::whereIn('patients_id', $list_ids)->get();
    //         $pdfFiles = [];

    //         foreach ($reports_list as $report) {
    //             $pdfFile =  $report->file;

    //             if (file_exists($pdfFile)) {
    //                 $pdfFiles[] = $pdfFile;
    //             }
    //         }

    //         $zip = new ZipArchive;

    //         $zipFileName = 'pdf_files.zip';
    //         $zipFilePath = public_path('zips/' . $zipFileName);

    //         if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    //             // Add each PDF file to the zip
    //             foreach ($pdfFiles as $pdfFile) {
    //                 $fileName = basename($pdfFile);
    //                 $added = $zip->addFile($pdfFile, $fileName);
    //                 if (!$added) {
    //                     // Log or echo the error
    //                     echo "Failed to add file $pdfFile to zip: " . $zip->getStatusString();
    //                 }
    //             }

    //             // Close the zip
    //             $zip->close();

    //             return response()->download($zipFilePath)->deleteFileAfterSend(true);
    //         } else {
    //             // Handle failure to create zip
    //             return 'Failed to create zip file';
    //         }

    //         dd($pdfFiles);

    //         $data_count = $patient->count();
    //         if (isset($data) && $data_count != 0) {
    //             $pdf = PDF::loadView('admin.backup.pdf', compact('data'));
    //             return $pdf->download($request->input('date_range') . '-report.pdf');
    //         }
    //         return redirect()->back()->with('success', "0 Record found");
    //     } else {
    //         return redirect()->back()->with('error', "Please select valid options");
    //     }
    // }




    // public function download(Request $request)
    // {
    //     $patient = Patient::query();
    //     if ($request->has('date_range')) {
    //         $dateRange = $request->input('date_range');
    //         switch ($dateRange) {
    //             case 'today':
    //                 $patient->whereDate('created_at', Carbon::today());
    //                 break;
    //             case 'yesterday':
    //                 $patient->whereDate('created_at', Carbon::yesterday());
    //                 break;
    //             case 'this_week':
    //                 $startOfWeek = Carbon::now()->startOfWeek();
    //                 $endOfWeek = Carbon::now()->endOfWeek();
    //                 $patient->whereDate('created_at', '>=', $startOfWeek)->whereDate('created_at', '<=', $endOfWeek);
    //                 break;
    //             case 'this_month':
    //                 $startOfMonth = Carbon::now()->startOfMonth();
    //                 $endOfMonth = Carbon::now()->endOfMonth();
    //                 $patient->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth);
    //                 break;
    //             case 'custom_month':
    //                 $startMonth = $request->start_date;
    //                 $endMonth = $request->end_date;
    //                 $patient->whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $endMonth);
    //                 break;
    //             case 'custom_year':
    //                 $patient->where('f_year', $request->select_year);
    //                 break;
    //             default:
    //                 // Handle invalid date range
    //                 return redirect()->back()->with('error', "Please select a valid date range");
    //         }
    //         $data = $patient->get();

    //         $list_ids = $patient->pluck('id')->toArray();
    //         $reports_list = Patientreport::whereIn('patients_id', $list_ids)->get();

    //         foreach ($reports_list as $report) {
    //             $pdfFile =  $report->file;

    //             if (file_exists(public_path() . $pdfFile)) {
    //                 // $this->reportdownload($report->file);
    //                 return response()->download(public_path() . $pdfFile);
    //             }
    //         }

    //         $data_count = $patient->count();
    //         if (isset($data) && $data_count != 0) {
    //             $pdf = PDF::loadView('admin.backup.pdf', compact('data'));
    //             return $pdf->download($request->input('date_range') . '-report.pdf');
    //         }
    //         return redirect()->back()->with('success', "0 Record found");
    //     } else {
    //         return redirect()->back()->with('error', "Please select valid options");
    //     }
    // }

    // public function reportdownload($filename)
    // {
    //     $sanitizedFilename = str_replace('/patientsdocs/', '', $filename);
    //     $filePath = public_path() . $filename;

    //     // dd($filePath);

    //     if (file_exists($filePath)) {
    //         // dd("inside");
    //         // Set the Content-Disposition header to force download
    //         // $headers = array('Content-Type: application/pdf',);
    //         // return Response::download($filePath);
    //         // return response()->download($filePath, $sanitizedFilename);
    //         // return response()->download($filePath);
    //     } else {
    //         // Handle file not found
    //         return response()->json(['error' => 'File not found.'], 404);
    //     }

    //     // return Response::download($file);
    // }


    public function download(Request $request)
    {
        $patient = Patient::query();
        if ($request->has('date_range')) {
            $dateRange = $request->input('date_range');
            switch ($dateRange) {
                case 'today':
                    $patient->whereDate('created_at', Carbon::today());
                    $zipName = 'today_' . Carbon::today()->format('Ymd');
                    break;
                case 'yesterday':
                    $patient->whereDate('created_at', Carbon::yesterday());
                    $zipName = 'yesterday_' . Carbon::yesterday()->format('Ymd');
                    break;
                case 'this_week':
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $patient->whereDate('created_at', '>=', $startOfWeek)->whereDate('created_at', '<=', $endOfWeek);

                    $startDay = $startOfWeek->format('d');
                    $endDay = $endOfWeek->format('d');
                    $month = $startOfWeek->format('F');
                    $year = $startOfWeek->format('Y');

                    $zipName = "Week of $startDay - $endDay $month $year";

                    break;
                case 'this_month':
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now()->endOfMonth();
                    $patient->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth);

                    $month = $startOfMonth->format('F');
                    $year = $startOfMonth->format('Y');

                    $zipName = "Month of $month $year";

                    break;
                case 'custom_month':
                    $startMonth = $request->start_date;
                    $endMonth = $request->end_date;
                    $patient->whereDate('created_at', '>=', $startMonth)->whereDate('created_at', '<=', $endMonth);

                    $start = Carbon::parse($request->start_date)->format('Ymd');
                    $end = Carbon::parse($request->end_date)->format('Ymd');

                    $zipName = "$start $end";

                    break;
                case 'custom_year':
                    $patient->where('f_year', $request->select_year);

                    $year = $request->select_year;

                    $zipName = "Financial year $year";

                    break;
                default:
                    // Handle invalid date range
                    return redirect()->back()->with('error', "Please select a valid date range");
            }
            $data = $patient->get();

            $list_ids = $patient->pluck('id')->toArray();
            $reports_list = Patientreport::whereIn('patients_id', $list_ids)->get();

            $filesToDownload = [];

            foreach ($reports_list as $report) {
                $pdfFile =  $report->file;

                $filePath = public_path($pdfFile);

                // Check if the file exists
                if (file_exists($filePath)) {
                    // Add file path to the array
                    $filesToDownload[] = $filePath;
                }
            }

            if (!empty($filesToDownload)) {
                // Create a temporary zip file
                $zipFilePath = public_path($zipName . '.zip');
                $zip = new ZipArchive();
                if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                    foreach ($filesToDownload as $file) {
                        // Add each file to the zip archive
                        $zip->addFile($file, basename($file));
                    }
                    $zip->close();

                    // Download the zip file
                    return response()->download($zipFilePath)->deleteFileAfterSend(true);
                } else {
                    // If zip creation fails, redirect back with an error message
                    return redirect()->back()->with('error', "Failed to create zip file");
                }
            } else {
                // If no file is found, return back with a message
                return redirect()->back()->with('success', "0 Record found");
            }
        } else {
            return redirect()->back()->with('error', "Please select valid options");
        }
    }

    public function downloadYearSlip(Request $request)
    {
        $slips = Slip::where('f_year', $request->select_year)->get();

        $filesToDownload = [];
        foreach ($slips as $slip) {

            $pdfFile =  $slip->file;

            $filePath = public_path('slipe/' . $pdfFile);

            if (file_exists($filePath)) {
                // Add file path to the array
                $filesToDownload[] = $filePath;
            }
        }

        if (!empty($filesToDownload)) {
            // Create a temporary zip file
            $zipFilePath = public_path($request->select_year . '.zip');
            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                foreach ($filesToDownload as $file) {
                    // Add each file to the zip archive
                    $zip->addFile($file, basename($file));
                }
                $zip->close();

                // Download the zip file
                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            } else {
                // If zip creation fails, redirect back with an error message
                return redirect()->back()->with('error', "Failed to create zip file");
            }
        } else {
            // If no file is found, return back with a message
            return redirect()->back()->with('success', "0 Record found");
        }
    }

    public function downloadYearSlipPdf(Request $request)
    {
        // $data = Slip::where('f_year', $request->select_year)->get();

        $data = Slip::where('f_year', $request->select_year)
            ->whereBetween('date', [
                Carbon::createFromDate(2024, 4, 1)->toDateString(),
                Carbon::createFromDate(2025, 3, 31)->toDateString()
            ])
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            });

        $data_count = count($data);
        if (isset($data) && $data_count != 0) {
            $pdf = PDF::loadView('admin.backup.slippdf', compact('data'));
            return $pdf->download($request->select_year . '-slip.pdf');
        }
        return redirect()->back()->with('success', "0 Record found");
    }

    public function todayBackupDownload(Request $request)
    {
        $patient = Patient::whereDate('created_at', Carbon::today())->get();
        $zipName = 'today_' . Carbon::today()->format('Ymd');

        $list_ids = $patient->pluck('id')->toArray();
        $reports_list = Patientreport::whereIn('patients_id', $list_ids)->get();

        $filesToDownload = [];

        foreach ($reports_list as $report) {
            $filePath = public_path($report->file);

            if (file_exists($filePath)) {
                $filesToDownload[] = $filePath;
            }
        }

        if (!empty($filesToDownload)) {
            // Create a temporary zip file
            $zipFilePath = public_path($zipName . '.zip');
            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                foreach ($filesToDownload as $file) {
                    // Add each file to the zip archive
                    $zip->addFile($file, basename($file));
                }
                $zip->close();

                // Download the zip file
                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            } else {
                // If zip creation fails, redirect back with an error message
                return redirect()->back()->with('error', "Failed to create zip file");
            }
        } else {
            // If no file is found, return back with a message
            return redirect()->back()->with('success', "0 Record found");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_last_slip = Slip::latest()->first();
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
