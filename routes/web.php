<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSlipsController;
use App\Http\Controllers\AdminBackupController;
use App\Http\Controllers\AdminFlowupController;
use App\Http\Controllers\AdminDoctorsController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminPatientsController;
use App\Http\Controllers\AdminShortCodeController;
use App\Http\Controllers\AdminCommissionController;
use App\Http\Controllers\AdminReportTypesController;
use App\Http\Controllers\AdminFinancialYearController;
use App\Http\Controllers\AdminChildReportTypesController;
use App\Http\Controllers\AdminSubChildReportTypesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
})->name('admin.login');

//  for admin registration below comment uncomment karvi and above auth.login ne comment karvi
// Route::get('/', function () {
//     return view('welcome');
// });
// Auth::routes();

// Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/login', [AdminController::class, 'login'])->name('login');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'usersession']], function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin');

    Route::get('/profile/{id}', [AdminController::class, 'profiledit'])->name('profile.edit');
    Route::post('/profile/update', [AdminController::class, 'profileUpdate'])->name('profile.update');

    Route::get('/admin/financial-year', [AdminController::class, 'financialYearList'])->name('financialyearlist');
    Route::post('/admin/set-financial-year', [AdminController::class, 'setFinancialYear'])->name('setfinancialyear');

    Route::get("admin/patients", [AdminPatientsController::class, 'index'])->name('admin.patients.index');
    Route::get('admin/patients/create', [AdminPatientsController::class, 'create'])->name('admin.patients.create');
    Route::post('admin/patients/store', [AdminPatientsController::class, 'store'])->name('admin.patients.store');
    Route::get('admin/patients/edit/{id}', [AdminPatientsController::class, 'edit'])->name('admin.patients.edit');
    Route::patch('admin/patients/update/{id}', [AdminPatientsController::class, 'update'])->name('admin.patients.update');
    Route::get('admin/patients/destroy/{id}', [AdminPatientsController::class, 'destroy'])->name('admin.patients.destroy');
    Route::delete('/mypatientsDeleteAll', [AdminPatientsController::class, 'deleteAll'])->name('deletepatientsAll');
    Route::get('/download', [AdminPatientsController::class, 'downloadSlip'])->name('downloadData');

    Route::post('/update/report', [AdminPatientsController::class, 'updateReportContent'])->name('update.report');

    Route::post('admin/patients/storereport', [AdminPatientsController::class, 'storeReport'])->name('admin.patients.storereport');
    Route::get('admin/patients/destroypatientsreport/{id}', [AdminPatientsController::class, 'destroyPatientReport'])->name('admin.patientsreport.destroy');

    Route::get('admin/patientsreport/edit/{id}', [AdminPatientsController::class, 'updateReport'])->name('admin.patientsreport.edit');

    Route::post('admin/get-child-reports', [AdminPatientsController::class, 'getChildReports'])->name('admin.getchild.reports');
    Route::post('admin/get-sub-child-reports', [AdminPatientsController::class, 'getSubChildReports'])->name('admin.getsubchild.reports');
    Route::post('admin/update-discount', [AdminPatientsController::class, 'updateDiscount'])->name('admin.update.discount');
    Route::post('admin/get-file-content', [AdminPatientsController::class, 'getFileContent'])->name('admin.getfile.content');
    Route::post('admin/import-doc-file', [AdminReportTypesController::class, 'storeDocFile'])->name('admin.import.file');
    Route::post('admin/update-payment-status', [AdminPatientsController::class, 'updatePaymentStatus'])->name('admin.update.payment');

    Route::post('/admin/reportamount/update', [AdminPatientsController::class, 'updateReportAmount'])->name('admin.report-amount.update');


    Route::get("admin/doctors", [AdminDoctorsController::class, 'index'])->name('admin.doctors.index');
    Route::get('admin/doctors/create', [AdminDoctorsController::class, 'create'])->name('admin.doctors.create');
    Route::post('admin/doctors/store', [AdminDoctorsController::class, 'store'])->name('admin.doctors.store');
    Route::get('admin/doctors/edit/{id}', [AdminDoctorsController::class, 'edit'])->name('admin.doctors.edit');
    Route::patch('admin/doctors/update/{id}', [AdminDoctorsController::class, 'update'])->name('admin.doctors.update');
    Route::get('admin/doctors/destroy/{id}', [AdminDoctorsController::class, 'destroy'])->name('admin.doctors.destroy');
    Route::delete('/mydoctorsDeleteAll', [AdminDoctorsController::class, 'deleteAll'])->name('deletedoctorsAll');

    Route::get("admin/report_types", [AdminReportTypesController::class, 'index'])->name('admin.report_types.index');
    Route::get('admin/report_types/create', [AdminReportTypesController::class, 'create'])->name('admin.report_types.create');
    Route::post('admin/report_types/store', [AdminReportTypesController::class, 'store'])->name('admin.report_types.store');
    Route::get('admin/report_types/edit/{id}', [AdminReportTypesController::class, 'edit'])->name('admin.report_types.edit');
    Route::patch('admin/report_types/update/{id}', [AdminReportTypesController::class, 'update'])->name('admin.report_types.update');
    Route::get('admin/report_types/destroy/{id}', [AdminReportTypesController::class, 'destroy'])->name('admin.report_types.destroy');
    Route::delete('/myreport_typesDeleteAll', [AdminReportTypesController::class, 'deleteAll'])->name('deletereport_typesAll');

    Route::get("admin/child_report_types", [AdminChildReportTypesController::class, 'index'])->name('admin.child_report_types.index');
    Route::get('admin/child_report_types/create', [AdminChildReportTypesController::class, 'create'])->name('admin.child_report_types.create');
    Route::post('admin/child_report_types/store', [AdminChildReportTypesController::class, 'store'])->name('admin.child_report_types.store');
    Route::get('admin/child_report_types/edit/{id}', [AdminChildReportTypesController::class, 'edit'])->name('admin.child_report_types.edit');
    Route::patch('admin/child_report_types/update/{id}', [AdminChildReportTypesController::class, 'update'])->name('admin.child_report_types.update');
    Route::get('admin/child_report_types/destroy/{id}', [AdminChildReportTypesController::class, 'destroy'])->name('admin.child_report_types.destroy');
    Route::delete('/mychild_report_typesDeleteAll', [AdminChildReportTypesController::class, 'deleteAll'])->name('deletechild_report_typesAll');

    Route::get("admin/financial_year", [AdminFinancialYearController::class, 'index'])->name('admin.financial_year.index');
    Route::get('admin/financial_year/create', [AdminFinancialYearController::class, 'create'])->name('admin.financial_year.create');
    Route::post('admin/financial_year/store', [AdminFinancialYearController::class, 'store'])->name('admin.financial_year.store');
    Route::get('admin/financial_year/edit/{id}', [AdminFinancialYearController::class, 'edit'])->name('admin.financial_year.edit');
    Route::patch('admin/financial_year/update/{id}', [AdminFinancialYearController::class, 'update'])->name('admin.financial_year.update');
    Route::get('admin/financial_year/destroy/{id}', [AdminFinancialYearController::class, 'destroy'])->name('admin.financial_year.destroy');

    Route::get("admin/backup", [AdminBackupController::class, 'index'])->name('admin.backup.index');
    Route::post('admin/backup_download', [AdminBackupController::class, 'download'])->name('admin.backup.download');
    Route::post('/finacial-year/slip-download', [AdminBackupController::class, 'downloadYearSlip'])->name('admin.year-slip.download');
    Route::post('/finacial-year/slip-pdf-download', [AdminBackupController::class, 'downloadYearSlipPdf'])->name('admin.year-slip-pdf.download');
    Route::get('admin/today-backup', [AdminBackupController::class, 'todayBackupDownload'])->name('admin.backup.download1');

    Route::get("admin/commission", [AdminCommissionController::class, 'index'])->name('admin.commission.index');
    Route::get('admin/commission_list', [AdminCommissionController::class, 'index'])->name('admin.commission.list');
    Route::get('admin/commission_download', [AdminCommissionController::class, 'download'])->name('admin.commission.download');

    Route::get("admin/setting", [AdminSettingController::class, 'index'])->name('admin.commission.index');
    Route::post('admin/setting/store', [AdminSettingController::class, 'store'])->name('admin.setting.store');
    Route::post('admin/change/f_year', [AdminSettingController::class, 'changeFyear'])->name('admin.change.f_year');

    Route::get('admin/get-related-text', [AdminShortCodeController::class, 'suggestion'])->name('admin.suggestion');

    Route::get("admin/short_code", [AdminShortCodeController::class, 'index'])->name('admin.short_code.index');
    Route::get('admin/short_code/create', [AdminShortCodeController::class, 'create'])->name('admin.short_code.create');
    Route::post('admin/short_code/store', [AdminShortCodeController::class, 'store'])->name('admin.short_code.store');
    Route::get('admin/short_code/edit/{id}', [AdminShortCodeController::class, 'edit'])->name('admin.short_code.edit');
    Route::patch('admin/short_code/update/{id}', [AdminShortCodeController::class, 'update'])->name('admin.short_code.update');
    Route::get('admin/short_code/destroy/{id}', [AdminShortCodeController::class, 'destroy'])->name('admin.short_code.destroy');

    Route::get("admin/slip", [AdminSlipsController::class, 'index'])->name('admin.slip.index');
    Route::get('admin/slip/create', [AdminSlipsController::class, 'create'])->name('admin.slip.create');
    Route::post('admin/slip/store', [AdminSlipsController::class, 'store'])->name('admin.slip.store');
    Route::get('admin/slip/edit/{id}', [AdminSlipsController::class, 'edit'])->name('admin.slip.edit');
    Route::patch('admin/slip/update/{id}', [AdminSlipsController::class, 'update'])->name('admin.slip.update');
    Route::get('admin/slip/destroy/{id}', [AdminSlipsController::class, 'destroy'])->name('admin.slip.destroy');

    Route::get("admin/slip-summary", [AdminSlipsController::class, 'indexSummary'])->name('admin.slip.summary');
    Route::post('/admin/slip-pdf', [AdminSlipsController::class, 'viewSummarySlipPdf'])->name('admin.slip-pdf.view');

    Route::post('/admin/slip-pdf-download', [AdminSlipsController::class, 'downloadSummarySlipPdf'])->name('admin.slip-pdf.download');

    Route::get("admin/flowup", [AdminFlowupController::class, 'index'])->name('admin.flowup.index');

    Route::get("admin/investigation", [AdminController::class, 'investigation'])->name('admin.investigation.report');
    Route::post("admin/investigation-pdf", [AdminController::class, 'viewInvestigationPDF'])->name('admin.investigation-pdf.report');
    Route::post("admin/investigation-download", [AdminController::class, 'downloadInvestigationPDF'])->name('admin.investigation-download.report');
});

//Clear Cache facade value:
Route::get('/admin/clear-cache', function () {
    Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/admin/optimize', function () {
    Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/admin/route-cache', function () {
    Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/admin/route-clear', function () {
    Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/admin/view-clear', function () {
    Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/admin/config-cache', function () {
    Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
