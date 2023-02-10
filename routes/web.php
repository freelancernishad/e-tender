<?php

use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


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

    // return view('form');
     $currentDate = date("d-m-Y H:i:s");

    $startDate = date("d-m-Y H:i:s",strtotime('19-02-2023 09:00:00'));

    $EndDate = date("d-m-Y H:i:s",strtotime('19-02-2023 14:00:00'));




   if($currentDate>$EndDate){

       return 'end';
    }

   if($currentDate>$startDate){

       return view('form');
    }else{

        return view('countdown');
   }





});


Route::post('/form/submit', function (Request $request) {

    $emailcheck = Tender::where('email',$request->email)->count();
 if($emailcheck>0){
    Session::flash('Smessage', 'Task was successful!');
    return redirect()->back();
 }





    $data = $request->except(['_token','bank_draft_image','deposit_details']);
    $bank_draft_image = $request->file('bank_draft_image');
    $extension = $bank_draft_image->getClientOriginalExtension();
    $path = public_path('files/bank_draft_image/');
    $fileName = uniqid().'.'.$extension;
    $bank_draft_image->move($path, $fileName);
    $bank_draft_image = asset('files/bank_draft_image/'.$fileName);

    $deposit_details = $request->file('deposit_details');
    $extension = $deposit_details->getClientOriginalExtension();
    $path = public_path('files/deposit_details/');
    $fileName = uniqid().'.'.$extension;
    $deposit_details->move($path, $fileName);
    $deposit_details = asset('files/deposit_details/'.$fileName);

    $data['bank_draft_image'] = $bank_draft_image;
    $data['deposit_details'] = $deposit_details;

  Tender::create($data);


});











Auth::routes();

// Route::group(['middleware' => ['is_admin']], function() {
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });

// Route::group(['middleware' => ['CustomerMiddleware']], function() {
// Route::get('/sub', [App\Http\Controllers\HomeController::class, 'sub'])->name('sub');
// });


Route::get('/{vue_capture?}', function () {
    return view('admin/layout.layout');
})->where('vue_capture', '[\/\w\.-]*');
