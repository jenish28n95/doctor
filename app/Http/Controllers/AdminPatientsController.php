<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use PDF;
use Validator;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Slip;
use App\Models\Rtype;
use App\Models\Doctor;
use App\Models\Wallet;
use App\Models\Patient;
use App\Models\Setting;
use App\Models\Childrtype;
use Illuminate\Http\Request;
use App\Models\Patientreport;
use App\Models\Shortcode;
use App\Models\Subchildrtype;
use Illuminate\Http\Response;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpWord\Shared\Html;
use ZipArchive;

class AdminPatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patients = Patient::where('f_year', Session::get('setfinancialyear'))->whereDate('created_at', Carbon::today())->get();
        if (isset($request->start_date) && isset($request->end_date) && isset($request->session)) {
            if ($request->session != 'all') {
                $patients = Patient::where('f_year', Session::get('setfinancialyear'))->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->where('session', $request->session)->orderBy('id', 'DESC')->get();
            } else {
                $patients = Patient::where('f_year', Session::get('setfinancialyear'))->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->orderBy('id', 'DESC')->get();
            }
        }
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors = Doctor::get();
        return view('admin.patients.create', compact('doctors'));
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
            'doctors_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            // 'mobile' => 'required|numeric|digits:10',
            // 'investigation' => 'required',
            'age' => 'required|integer|between:1,100',
            'session' => 'required',
            'mediclaim' => 'required',
            'arrival_time' => 'required',
            // 'payment' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        $patient = Patient::create($request->all());

        $f_year = Session::get('setfinancialyear');
        $self_id = Doctor::where('name', 'self')->value('id');
        // $patient = Patient::where('id', $patient->id)->first();

        if ($patient->doctors_id != $self_id) {
            $wallet = new Wallet;
            $wallet->doctors_id = $patient->doctors_id;
            $wallet->patients_id = $patient->id;
            $wallet->comm_amount = 0;
            $wallet->comm_date = $patient->created_at;
            $wallet->f_year = $f_year;
            $wallet->save();
        }

        return redirect('/admin/patients/edit/' . $patient->id);
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
        $patientreports = Patientreport::where('patients_id', $id)->get();
        $doctors = Doctor::get();
        $rtypes = Rtype::get();
        $patient = Patient::findOrFail($id);
        return view('admin.patients.edit', compact('doctors', 'patient', 'rtypes', 'patientreports'));
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
            'doctors_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            // 'mobile' => 'required|numeric|digits:10',
            // 'investigation' => 'required',
            'age' => 'required|integer|between:1,100',
            'session' => 'required',
            'mediclaim' => 'required',
            'arrival_time' => 'required',
            // 'payment' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        $patient = Patient::findOrFail($id);

        $olddoctor = Doctor::where('id', $patient->doctors_id)->first();
        $doldname = $olddoctor->name;

        $doctor = Doctor::where('id', $request->doctors_id)->first();
        $doctorname = $doctor->name;

        $name = $patient->name;

        $patientreports = Patientreport::where('patients_id', $patient->id)->get();

        foreach ($patientreports as $patientreport) {
            $update = $patientreport->report_content;

            $update = str_replace($name, $request->name, $update);
            $update = str_replace($doldname, $doctorname, $update);
            Patientreport::where('id', $patientreport->id)
                ->update(['report_content' => $update]);
        }


        $input = $request->all();
        $patient->update($input);

        $self_id = Doctor::where('name', 'self')->value('id');
        $f_year = Session::get('setfinancialyear');

        if ($patient->doctors_id == $self_id) {
            Wallet::where('patients_id', $id)
                ->where('f_year', $f_year)
                ->whereDate('comm_date', $patient->created_at)
                ->delete();
        } else {
            Wallet::where('patients_id', $id)
                ->where('f_year', $f_year)
                ->whereDate('comm_date', $patient->created_at)
                ->update(['doctors_id' => $patient->doctors_id]);
        }

        return redirect('admin/patients')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);

        $reports = Patientreport::where('patients_id', $patient->id)->get();
        foreach ($reports as $report) {
            if ($report->file != '/patientsdocs/') {
                if (file_exists(public_path() . $report->file)) {
                    unlink(public_path() . $report->file);
                }
            }
            $report->delete();
        }

        $commission = Wallet::where('patients_id', $patient->id)->first();
        if (isset($commission)) {
            $commission->delete();
        }

        $patient->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }

    public function storeReport(Request $request)
    {
        $patient = Patient::findOrFail($request->patients_id);
        $f_year = Session::get('setfinancialyear');

        $htmlContent  = $request->editContent;

        // dd($htmlContent);

        $htmlContent = '<div style="width: 90%; margin: 15% auto 0 auto;">' . $htmlContent . '</div>';
        $htmlContent = str_replace('margin-left: 3in', 'margin-left: 2in', $htmlContent);
        // $htmlContent = str_replace('border-left-style: double;', 'border-left-style: double;width:20%;', $htmlContent);
        // $htmlContent = str_replace('border-right-style: double;', 'border-right-style: double;width:15%;', $htmlContent);

        // dd($htmlContent);

        $options = new Options();
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($htmlContent);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $rtypes = Rtype::where('id', $request->report_id)->first();

        // Generate PDF file name
        $pdfFileName = str_replace(' ', '-', $patient->name) . '-' . str_replace(' ', '-', $rtypes->name) . '-' . Carbon::today()->format('Ymd') . '-' . time() . ".pdf";

        // Save the PDF content to a file
        $pdfFilePath = public_path('patientsdocs/' . $pdfFileName);
        file_put_contents($pdfFilePath, $dompdf->output());

        $data = new Patientreport;
        $data->patients_id = $request->patients_id;
        $data->report_id = $request->report_id;
        $data->childreport_id = $request->childreport_id;
        $data->amount = $request->amount;
        $data->file = $pdfFileName;
        $data->report_content = $htmlContent;
        $data->created_at = $request->created_at;
        $data->save();

        $total = 0;
        $reports = Patientreport::where('patients_id', $patient->id)->get();
        foreach ($reports as $report) {
            $total += $report->amount;
        }

        $patient->basic_amount = $total;
        $patient->net_amount = $total;
        $patient->save();

        $result = 0;
        $commission = 0;

        $self_id = Doctor::where('name', 'self')->value('id');
        $f_setting = Setting::where('key', 'Fixed_amount')->first();
        $p_setting = Setting::where('key', 'Custom_percentage')->first();

        $wallet_count = Wallet::where('patients_id', $request->patients_id)->where('f_year', $f_year)->whereDate('comm_date', $patient->created_at)->count();

        $getwallet = Wallet::where('patients_id', $request->patients_id)->where('f_year', $f_year)->whereDate('comm_date', $patient->created_at)->first();

        if ($patient->doctors_id != $self_id) {
            if ($patient->discount != 0 && $patient->discount != '') {
                if ($patient->discount_type == 'per') {
                    $result = ($patient->discount / 100) * ($patient->basic_amount);
                }
                if ($patient->discount_type == 'fix') {
                    $result = $patient->discount;
                }
                $commission = $getwallet->comm_amount;
            } else {
                if ($patient->doctors_id == $self_id) {
                    $commission = 0;
                } elseif ($patient->net_amount >= $f_setting->amount) {
                    $commission = $f_setting->comm_amount;
                } elseif ($patient->net_amount < $f_setting->amount) {
                    $commission = $patient->net_amount * $p_setting->comm_amount;
                }
            }

            $patient->discount_amount = $result;
            $patient->net_amount = ($patient->basic_amount) - $result;
            $patient->save();

            if ($wallet_count > 0) {
                Wallet::where('patients_id', $patient->id)
                    ->where('f_year', $f_year)
                    ->whereDate('comm_date', $patient->created_at)
                    ->update(['comm_amount' => $commission]);
            } else {
                $wallet = new Wallet;
                $wallet->doctors_id = $patient->doctors_id;
                $wallet->patients_id = $patient->id;
                $wallet->comm_amount = $commission;
                $wallet->comm_date = $patient->created_at;
                $wallet->f_year = $f_year;
                $wallet->save();
            }
        } else {
            Wallet::where('patients_id', $patient->id)
                ->where('f_year', $f_year)
                ->whereDate('comm_date', $patient->created_at)
                ->delete();
            if ($patient->discount != 0 && $patient->discount != '') {
                if ($patient->discount_type == 'per') {
                    $result = ($patient->discount / 100) * ($patient->basic_amount);
                }
                if ($patient->discount_type == 'fix') {
                    $result = $patient->discount;
                }
                $patient->discount_amount = $result;
                $patient->net_amount = ($patient->basic_amount) - $result;
                $patient->save();
            }
        }

        $cash = isset($patient->cash_amount) ? $patient->cash_amount : 0;
        $paytm = isset($patient->paytm_amount) ? $patient->paytm_amount : 0;
        $pay = $cash + $paytm;
        $balance = ($patient->net_amount) - ($cash + $paytm);

        if ($patient->net_amount == $pay) {
            $payment = 'done';
        } else {
            $payment = 'pending';
        }

        $patient->balance = $balance;
        $patient->payment = $payment;
        $patient->save();

        return redirect()->back()->with('success', "Update Record Successfully");
    }

    public function destroyPatientReport($id)
    {
        $data = Patientreport::findOrFail($id);

        if ($data->file != '/patientsdocs/') {
            if (file_exists(public_path() . $data->file)) {
                unlink(public_path() . $data->file);
            }
        }

        $data->delete();

        $f_year = Session::get('setfinancialyear');
        $count = Patientreport::where('patients_id', $data->patients_id)->count();
        $patient = Patient::findOrFail($data->patients_id);

        if ($count == 0) {
            $patient->basic_amount = 0;
            $patient->discount = 0;
            $patient->net_amount = 0;
            $patient->discount_amount = 0;
            $patient->payment_mode = '';
            $patient->cash_amount = 0;
            $patient->paytm_amount = 0;
            $patient->balance = 0;
            $patient->payment = '';
            $patient->discount_type = 'per';
            $patient->save();

            Wallet::where('patients_id', $data->patients_id)->where('f_year', $f_year)->whereDate('comm_date', $patient->created_at)->delete();
        } else {

            $total = 0;
            $reports = Patientreport::where('patients_id', $patient->id)->get();
            foreach ($reports as $report) {
                $total += $report->amount;
            }

            $patient->basic_amount = $total;
            $patient->net_amount = $total;
            $patient->save();

            $result = 0;
            $commission = 0;
            $self_id = Doctor::where('name', 'self')->value('id');
            $f_setting = Setting::where('key', 'Fixed_amount')->first();
            $p_setting = Setting::where('key', 'Custom_percentage')->first();

            $wallet_count = Wallet::where('patients_id', $data->patients_id)->where('f_year', $f_year)->whereDate('comm_date', $patient->created_at)->count();

            $getwallet = Wallet::where('patients_id', $patient->id)->where('f_year', $f_year)->whereDate('comm_date', $patient->created_at)->first();

            if ($patient->doctors_id != $self_id) {
                if ($patient->discount != 0 && $patient->discount != '') {
                    if ($patient->discount_type == 'per') {
                        $result = ($patient->discount / 100) * ($patient->basic_amount);
                    }
                    if ($patient->discount_type == 'fix') {
                        $result = $patient->discount;
                    }
                    $commission = $getwallet->comm_amount;
                } else {
                    if ($patient->doctors_id == $self_id) {
                        $commission = 0;
                    } elseif ($patient->net_amount >= $f_setting->amount) {
                        $commission = $f_setting->comm_amount;
                    } elseif ($patient->net_amount < $f_setting->amount) {
                        $commission = $patient->net_amount * $p_setting->comm_amount;
                    }
                }
                $patient->discount_amount = $result;
                $patient->net_amount = ($patient->basic_amount) - $result;
                $patient->save();

                if ($wallet_count > 0) {
                    Wallet::where('patients_id', $patient->patients_id)
                        ->where('f_year', $f_year)
                        ->whereDate('comm_date', $patient->created_at)
                        ->update(['comm_amount' => $commission]);
                } else {
                    $wallet = new Wallet;
                    $wallet->doctors_id = $patient->doctors_id;
                    $wallet->patients_id = $patient->patients_id;
                    $wallet->comm_amount = $commission;
                    $wallet->comm_date = $patient->created_at;
                    $wallet->f_year = $f_year;
                    $wallet->save();
                }
            } else {
                Wallet::where('patients_id', $patient->id)
                    ->where('f_year', $f_year)
                    ->whereDate('comm_date', $patient->created_at)
                    ->delete();
                if ($patient->discount != 0 && $patient->discount != '') {
                    if ($patient->discount_type == 'per') {
                        $result = ($patient->discount / 100) * ($patient->basic_amount);
                    }
                    if ($patient->discount_type == 'fix') {
                        $result = $patient->discount;
                    }
                    $patient->discount_amount = $result;
                    $patient->net_amount = ($patient->basic_amount) - $result;
                    $patient->save();
                }
            }

            $cash = isset($patient->cash_amount) ? $patient->cash_amount : 0;
            $paytm = isset($patient->paytm_amount) ? $patient->paytm_amount : 0;
            $pay = $cash + $paytm;
            $balance = ($patient->net_amount) - ($cash + $paytm);

            if ($patient->net_amount == $pay) {
                $payment = 'done';
            } else {
                $payment = 'pending';
            }

            $patient->balance = $balance;
            $patient->payment = $payment;
            $patient->save();
        }
        return Redirect::back();
    }

    public function updateReportContent(Request $request)
    {
        $patientreport = Patientreport::findOrFail($request->patientreportid);
        $patient = Patient::where('id', $patientreport->patients_id)->first();

        if ($patientreport->file != '/patientsdocs/') {
            if (file_exists(public_path() . $patientreport->file)) {
                unlink(public_path() . $patientreport->file);
            }
        }

        $htmlContent  = $request->report_content;

        $htmlContent = '<div style="width: 90%; margin: 15% auto 0 auto;">' . $htmlContent . '</div>';
        $htmlContent = str_replace('margin-left: 3in', 'margin-left: 2in', $htmlContent);
        // $htmlContent = str_replace('<table', '<table style="border-collapse: collapse; border-spacing: 0; padding: 0px;width:100%;"', $htmlContent);
        // $htmlContent = str_replace('<td style="', '<td style="border: 1px solid #000; padding: 0;"', $htmlContent);

        $options = new Options();
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($htmlContent);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $rtypes = Rtype::where('id', $patientreport->report_id)->first();

        // Generate PDF file name
        $pdfFileName = str_replace(' ', '-', $patient->name) . '-' . str_replace(' ', '-', $rtypes->name) . '-' . Carbon::today()->format('Ymd') . '-' . time() . ".pdf";

        // Save the PDF content to a file
        $pdfFilePath = public_path('patientsdocs/' . $pdfFileName);
        file_put_contents($pdfFilePath, $dompdf->output());

        Patientreport::where('id', $patientreport->id)
            ->update(['report_content' => $htmlContent, 'file' => $pdfFileName]);

        // Redirect back or do something else
        return redirect()->back()->with('success', 'Report updated successfully');
    }

    public function updateDiscount(Request $request)
    {
        $f_year = Session::get('setfinancialyear');
        $result = 0;
        $total = 0;
        $patient = Patient::findOrFail($request->id);

        $reports = Patientreport::where('patients_id', $patient->id)->get();
        foreach ($reports as $report) {
            $total += $report->amount;
        }

        $patient->basic_amount = $total;
        $patient->net_amount = $total;
        $patient->save();

        if ($patient->discount_type == 'per') {
            $result = ($request->discount / 100) * ($patient->basic_amount);
        }
        if ($patient->discount_type == 'fix') {
            $result = $request->discount;
        }

        $patient->discount_amount = $result;
        $patient->net_amount = ($patient->basic_amount) - $result;
        $patient->save();

        $cash = isset($request->cash_amount) ? $request->cash_amount : 0;
        $paytm = isset($request->paytm_amount) ? $request->paytm_amount : 0;
        $pay = $cash + $paytm;
        $balance = ($patient->net_amount) - ($cash + $paytm);

        if ($patient->net_amount == $pay) {
            $payment = 'done';
        } else {
            $payment = 'pending';
        }

        if ($patient->discount_type == 'per') {
            $result = ($request->discount / 100) * ($patient->basic_amount);
        }
        if ($patient->discount_type == 'fix') {
            $result = $request->discount;
        }

        $patient->payment_mode = $request->payment_mode;
        $patient->cash_amount = $cash;
        $patient->paytm_amount = $paytm;
        $patient->balance = $balance;
        $patient->payment = $payment;
        $patient->discount_type = $request->discount_type;
        $patient->discount = $request->discount;
        // $patient->discount_amount = $result;
        // $patient->net_amount = ($patient->basic_amount) - $result;
        $patient->save();

        Wallet::where('patients_id', $patient->id)
            ->where('f_year', $f_year)
            ->whereDate('comm_date', $patient->created_at)
            ->update(['comm_amount' => $request->doctor_comm]);

        $self_id = Doctor::where('name', 'self')->value('id');
        $f_setting = Setting::where('key', 'Fixed_amount')->first();
        $p_setting = Setting::where('key', 'Custom_percentage')->first();

        $wallet_count = Wallet::where('patients_id', $request->id)->where('f_year', $f_year)->whereDate('comm_date', $patient->created_at)->count();

        $getwallet = Wallet::where('patients_id', $request->id)->where('f_year', $f_year)->whereDate('comm_date', $patient->created_at)->first();

        if (($patient->doctors_id != $self_id)) {
            if ($patient->discount != 0 && $patient->discount != '') {
                // if ($patient->discount_type == 'per') {
                //     $result = ($patient->discount / 100) * ($patient->basic_amount);
                // }
                // if ($patient->discount_type == 'fix') {
                //     $result = $patient->discount;
                // }
                $commission = $getwallet->comm_amount;
            } else {
                if ($patient->doctors_id == $self_id) {
                    $commission = 0;
                } elseif ($patient->net_amount >= $f_setting->amount) {
                    $commission = $f_setting->comm_amount;
                } elseif ($patient->net_amount < $f_setting->amount) {
                    $commission = $patient->net_amount * $p_setting->comm_amount;
                }
            }

            // $patient->discount_amount = $result;
            // $patient->net_amount = ($patient->basic_amount) - $result;
            // $patient->balance = ($patient->basic_amount) - $result;
            // $patient->save();

            if ($wallet_count > 0) {
                Wallet::where('patients_id', $patient->id)
                    ->where('f_year', $f_year)
                    ->whereDate('comm_date', $patient->created_at)
                    ->update(['comm_amount' => $commission]);
            } else {
                $wallet = new Wallet;
                $wallet->doctors_id = $patient->doctors_id;
                $wallet->patients_id = $patient->id;
                $wallet->comm_amount = $commission;
                $wallet->comm_date = $patient->created_at;
                $wallet->f_year = $f_year;
                $wallet->save();
            }
        } else {
            Wallet::where('patients_id', $patient->id)
                ->where('f_year', $f_year)
                ->whereDate('comm_date', $patient->created_at)
                ->delete();
            if ($patient->discount != 0 && $patient->discount != '') {
                // if ($patient->discount_type == 'per') {
                //     $result = ($patient->discount / 100) * ($patient->basic_amount);
                // }
                // if ($patient->discount_type == 'fix') {
                //     $result = $patient->discount;
                // }
                // $patient->discount_amount = $result;
                // $patient->net_amount = ($patient->basic_amount) - $result;
                // $patient->save();
            }
        }
        return Redirect::back();
    }

    public function updatePaymentStatus(Request $request)
    {
        $patient = Patient::findOrFail($request->id);

        $cash = isset($request->cash_amount) ? $request->cash_amount : 0;
        $paytm = isset($request->paytm_amount) ? $request->paytm_amount : 0;
        $pay = $cash + $paytm;
        $balance = ($patient->net_amount) - ($cash + $paytm);

        if ($patient->net_amount == $pay) {
            $payment = 'done';
        } else {
            $payment = 'pending';
        }

        $patient->payment_mode = $request->payment_mode;
        $patient->cash_amount = $cash;
        $patient->paytm_amount = $paytm;
        $patient->balance = $balance;
        $patient->payment = $payment;
        $patient->save();
        return Redirect::back();
    }

    public function getChildReports(Request $request)
    {
        $reportid = $request->input('report_id');

        $rtype = Rtype::where('id', $reportid)->first();

        $child_type = Childrtype::where('rtypes_id', $rtype->id)->get();

        return response()->json($child_type);
    }

    public function getSubChildReports(Request $request)
    {
        $reportid = $request->input('childreport_id');
        $rid = $request->input('report_id');

        $rtype = Childrtype::where('id', $reportid)->first();

        $mediaPath = public_path('reports/' . $rid . '/' . $reportid);
        if (File::exists($mediaPath)) {
            $filesInFolder = File::files($mediaPath);
            $docxFiles = [];

            foreach ($filesInFolder as $path) {
                $files = pathinfo($path);
                if ($files['extension'] === 'docx' || $files['extension'] === 'doc') {
                    $docxFiles[] = $files;
                }
            }

            return response()->json(['all_media' => $docxFiles]);
        } else {
            return response()->json(['error' => 'Directory not found']);
        }
    }

    public function getFileContent(Request $request)
    {
        $childid = $request->input('child_id');
        $rid = $request->input('report_id');
        $filename = $request->input('selected_file');
        $patientsId = $request->input('patients_id');

        $patient = Patient::where('id', $patientsId)->first();
        $doctor = Doctor::where('id', $patient->doctors_id)->first();

        $filePath  = public_path('reports/' . $rid . '/' . $childid . '/' . $filename);

        if (File::exists($filePath)) {
            $phpWord = IOFactory::load($filePath);

            // Save as HTML
            $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
            $htmlFilePath = storage_path('app/public/') . $filename . '.html';
            $htmlWriter->save($htmlFilePath);

            // Read HTML content
            $content = file_get_contents($htmlFilePath);

            // Clean up temporary HTML file
            unlink($htmlFilePath);

            $pname = $patient->name;
            $age = $patient->age . ' ' . $patient->year . '/ ' . ($patient->sex == 'male' ? 'M' : 'F');
            $doctorname = 'DR.' . $doctor->name . '-' . $doctor->degree;
            $formatted_date = Carbon::createFromFormat('Y-m-d H:i:s', $patient->created_at);
            $date = $formatted_date->format('d/m/Y');

            $content = str_replace("PHPWord", " ", $content);
            $content = str_replace("{patname}", '&nbsp;' . $pname, $content);
            $content = str_replace("{patage}", '&nbsp;' . $age, $content);
            $content = str_replace("{refdoctor}", '&nbsp;' . $doctorname, $content);
            $content = str_replace("{pat-date}", '&nbsp;' . $date, $content);
            $content = preg_replace('/<p>&nbsp;<\/p>/', '', $content);
            $content = str_replace('bgcolor="#auto"', '', $content);
            $content = str_replace('margin-left: 3in', 'margin-left: 0in', $content);
            $content = str_replace('margin-left: 1134in', 'margin-left: 3in', $content);
            $content = str_replace('margin-left: 1440in', 'margin-left: 3in', $content);
            $content = str_replace('margin-left: 1080in', 'margin-left: 3in', $content);
            $content = str_replace('margin-left: 1620in', 'margin-left: 3in', $content);
            $content = str_replace('margin-left: 540in', 'margin-left: 3in', $content);
            $content = str_replace('margin-left: 720in', 'margin-left: 3in', $content);
            $content = str_replace('margin-left: 180in', 'margin-left: 3in', $content);
            $content = str_replace('margin-left: 360in', 'margin-left: 3in', $content);
            $content = str_replace('margin-left: 1800in', 'margin-left: 3in', $content);

            // $content = str_replace('<p style="text-align: justify;"><span style="font-weight: bold;">', '<span style="font-weight: bold;">', $content);
            // $content = str_replace('<p style="text-align: justify;"><span style=', '<span style=', $content);
            // $content = str_replace('<p style="text-align: justify;">', '', $content);
            $content = preg_replace('/<\/p>/', '', $content);
            // $content = str_replace("<div style='page: page1'>", "\n<p></p>\n<p></p>\n<p></p>\n<p></p>\n<div style='page: page1'>", $content);
            // $content = trim($content);

            return response()->json(['content' => $content]);
        } else {
            return response()->json(['error' => 'File not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function downloadSlip(Request $request)
    {
        $f_year = Session::get('setfinancialyear');
        $selectedIds = $request->input('ids');

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', "please select patient for slip");
        }

        $patients = Patient::whereIn('id', explode(',', $selectedIds))->orderBy('id', 'ASC')->get();

        $fileNames = [];

        $get_last_slip = Slip::where('f_year', $f_year)->orderBy('id', 'Desc')->first();

        $no = 1;
        if (isset($get_last_slip)) {
            $no = ($get_last_slip->sr_no) + 1;
        }

        $no = str_pad($no, 4, '0', STR_PAD_LEFT);

        $filesToDownload = [];

        foreach ($patients as $patient) {
            if ($patient->is_slip == 0) {
                $patientreports = Patientreport::where('patients_id', $patient->id)->get();

                if (!isset($patientreports)) {
                    continue;
                }

                $pdf = PDF::loadView('admin.patients.slipe', compact('patient', 'patientreports', 'no'));

                if (!$patient->created_at->startOfDay()->equalTo(Carbon::today())) {

                    // $fileName = $no . '-' . str_replace(' ', '-', $patient->name) . '.pdf';
                    // $pdf->save(public_path('slipe/') . $fileName);
                    // $fileNames[] = $fileName;

                    // $filePath = public_path('slipe/') . $fileName;
                    // $filesToDownload[] = $filePath;

                    // $slip = new Slip;
                    // $slip->patients_id = $patient->id;
                    // $slip->sr_no = $no;
                    // $slip->date = $patient->created_at;
                    // $slip->file = $fileName;
                    // $slip->f_year = $f_year;
                    // $slip->save();

                    // Patient::where('id', $patient->id)->update(['is_slip' => 1]);

                    // $no++;
                    // $no = str_pad($no, 4, '0', STR_PAD_LEFT);
                } else {

                    $fileName = $no . '-' . str_replace(' ', '-', $patient->name) . '.pdf';
                    $pdf->save(public_path('slipe/') . $fileName);
                    $fileNames[] = $fileName;

                    $filePath = public_path('slipe/') . $fileName;
                    $filesToDownload[] = $filePath;

                    $slip = new Slip;
                    $slip->patients_id = $patient->id;
                    $slip->sr_no = $no;
                    $slip->date = $patient->created_at;
                    $slip->file = $fileName;
                    $slip->f_year = $f_year;
                    $slip->save();

                    Patient::where('id', $patient->id)->update(['is_slip' => 1]);

                    $no++;
                    $no = str_pad($no, 4, '0', STR_PAD_LEFT);
                }
            } else {
                continue;
            }
        }

        if (!empty($filesToDownload)) {
            // $toda = Carbon::today()->format('Ymd');

            // $zipFilePath = public_path($toda . '-slips.zip');
            // $zip = new ZipArchive();
            // if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            //     foreach ($filesToDownload as $file) {
            //         // Add each file to the zip archive
            //         $zip->addFile($file, basename($file));
            //     }
            //     $zip->close();

            //     return response()->download($zipFilePath)->deleteFileAfterSend(true);
            // } else {
            //     // If zip creation fails, redirect back with an error message
            //     return redirect()->back()->with('error', "Failed to create zip file");
            // }
        }

        return redirect()->back()->with('success', "Slip Download succesfully");
    }
}
