<?php

use App\Http\Controllers\Admin\AnalysisBiomaterialController as AdminAnalysisBiomaterialController;
use App\Http\Controllers\Admin\AnalysisController as AdminAnalysisController;
use App\Http\Controllers\Admin\AnalysisParameterController as AdminAnalysisParameterController;
use App\Http\Controllers\Admin\BiomaterialController as AdminBiomaterialController;
use App\Http\Controllers\Admin\ComplexController as AdminComplexController;
use App\Http\Controllers\Admin\ContractController as AdminContractController;
use App\Http\Controllers\Admin\DiscountCardController as AdminDiscountCardController;
use App\Http\Controllers\Admin\DiscountController as AdminDiscountController;
use App\Http\Controllers\Admin\MethodController as AdminMethodController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\PriceController as AdminPriceController;
use App\Http\Controllers\Admin\TestTubeController as AdminTestTubeController;
use App\Http\Controllers\Admin\UnitController as AdminUnitController;
use App\Http\Controllers\LaboratoryAssistant\TicketController as LaboratoryAssistantTicketController;
use App\Http\Controllers\PermissionController as PermissionController;
use App\Http\Controllers\RoleController as RoleController;
use App\Http\Controllers\UserController as UserController;
use App\Http\Controllers\XmlToHtmlFormConverter as XmlToHtmlFormConverter;
use Illuminate\Support\Facades\Route;

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

//Route::get('/','Controller@index');
Route::get('/', 'App\Http\Controllers\Controller@home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['role:admin'])->prefix('admin_panel')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('homeadmin');
    Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
});

Route::get('/xml', function () {
    return EnvUser::get_username();
});

Route::get('/blade', [XmlToHtmlFormConverter::class, 'index']);


Route::middleware(['role:userrole|admin'])->prefix('admin_panel')->group(function () {

    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('homeadmin');
    Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);


});

Route::middleware('auth')->prefix('admin_panel')->group(function () {
    Route::resource('test_tubes', AdminTestTubeController::class);
    Route::get('/test_tubes_ajax', [AdminTestTubeController::class, 'listAjax'])->name('test_tubes.ajax');

    Route::resource('biomaterials', AdminBiomaterialController::class);
    Route::get('/biomaterials_ajax', [AdminBiomaterialController::class, 'listAjax'])->name('biomaterials.ajax');

    Route::resource('complex', AdminComplexController::class);
    Route::get('/complex_ajax', [AdminComplexController::class, 'listAjax'])->name('complex.ajax');

    Route::resource('analysis', AdminAnalysisController::class);
    Route::get('/analysis_ajax', [AdminAnalysisController::class, 'listAjax'])->name('analysis.ajax');
    Route::post('/analysis/{analysis}/status', [AdminAnalysisController::class, 'status'])->name('analysis.status');
    Route::post('/analysis/{analysis}/complex/{complex}', [AdminAnalysisController::class, 'complex'])->name('analysis.complex.add');

    Route::resource('analysis.parameters', AdminAnalysisParameterController::class);
    Route::get('/analysis/{analysis}/parameters_ajax', [AdminAnalysisParameterController::class, 'listAjax'])->name('analysis.parameters.ajax');

    Route::resource('analysis.biomaterials', AdminAnalysisBiomaterialController::class);
    Route::get('/analysis/{analysis}/biomaterials_ajax', [AdminAnalysisBiomaterialController::class, 'listAjax'])->name('analysis.biomaterials.ajax');

    Route::resource('unit', AdminUnitController::class);
    Route::get('/unit_ajax', [AdminUnitController::class, 'listAjax'])->name('unit.ajax');

    Route::resource('method', AdminMethodController::class);
    Route::get('/method_ajax', [AdminMethodController::class, 'listAjax'])->name('method.ajax');

    Route::resource('price', AdminPriceController::class);
    Route::get('/price_ajax', [AdminPriceController::class, 'listAjax'])->name('price.ajax');
    Route::post('/price/{price}/analysis_biomaterial/{analysis_biomaterial}', [AdminPriceController::class, 'analysisBiomaterial'])->name('price.analysis_biomaterial');
    Route::get('/price/{price}/analysis_biomaterial/{analysis_biomaterial}/test', [AdminPriceController::class, 'test'])->name('price.analysis_biomaterial.test');

    Route::resource('partner', AdminPartnerController::class);
    Route::get('/partner_ajax', [AdminPartnerController::class, 'listAjax'])->name('partner.ajax');

    Route::resource('partner.contract', AdminContractController::class);
    Route::get('/partner/{partner}/contract_ajax', [AdminContractController::class, 'listAjax'])->name('partner.contract.ajax');

    Route::resource('discount_card', AdminDiscountCardController::class);
    Route::get('/discount_card_ajax', [AdminDiscountCardController::class, 'listAjax'])->name('discount_card.ajax');

    Route::resource('discount', AdminDiscountController::class);
    Route::get('/discount_ajax', [AdminDiscountController::class, 'listAjax'])->name('discount.ajax');
});
Route::post('/percent_of_discount_card', [AdminDiscountCardController::class, 'getDiscount'])->name('discount_card.percent');

Route::resource('ticket', LaboratoryAssistantTicketController::class);
Route::get('/ticket_ajax', [LaboratoryAssistantTicketController::class, 'listAjax'])->name('ticket.ajax');
Route::post('/ticket_parameters', [LaboratoryAssistantTicketController::class, 'parameters'])->name('ticket.parameters');

Route::get('/test', function(){
    return view('layouts.test_layout');
})->name('test');
