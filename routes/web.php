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



    $tenderCount =  Tender::count();
    if($tenderCount>0){
        $tender = Tender::orderBy('id','desc')->first();
        $dorId = $tender->dorId+1;
    }else{
        $dorId = 120001;
    }



    // return view('form');
      $currentDate = strtotime(date("d-m-Y H:i:s"));

    $startDate = strtotime(date("d-m-Y H:i:s",strtotime(env('STARTFORM'))));

    $EndDate = strtotime(date("d-m-Y H:i:s",strtotime(env('ENDFORM'))));




   if($currentDate>$EndDate){
       return '<h1 style="text-align:center;margin-top:20px;color:red">দরপত্র দাখিলের সময় শেষ</h1>';
    }

   if($currentDate>$startDate){

       return view('form',compact('dorId'));
    }else{

        return view('countdown');
   }





});


Route::post('/form/submit', function (Request $request) {


//    return $request->all();


//     $emailcheck = Tender::where('mobile',$request->mobile)->count();
//  if($emailcheck>0){
//     Session::flash('Fmessage', 'আপনি ইতিমধ্যে দরপত্র দাখিল করেছেন');
//     return redirect()->back();
//  }





    $data = $request->except(['_token','bank_draft_image','deposit_details']);
    $bank_draft_image = $request->file('bank_draft_image');
    $extension = $bank_draft_image->getClientOriginalExtension();
    $path = public_path('files/bank_draft_image/');
    $fileName = $request->dorId.'-'.uniqid().'.'.$extension;
    $bank_draft_image->move($path, $fileName);
    $bank_draft_image = asset('files/bank_draft_image/'.$fileName);

    $deposit_details = $request->file('deposit_details');
    $extension = $deposit_details->getClientOriginalExtension();
    $path = public_path('files/deposit_details/');
    $fileName = $request->dorId.'-'.uniqid().'.'.$extension;
    $deposit_details->move($path, $fileName);
    $deposit_details = asset('files/deposit_details/'.$fileName);

    $data['bank_draft_image'] = $bank_draft_image;
    $data['deposit_details'] = $deposit_details;

  Tender::create($data);
  Session::flash('Smessage', 'আপনার দরপত্রটি দাখিল হয়েছে');
  return redirect()->back();


});

Route::get('/pdf/sder/download', function (Request $request) {

$html = '
<style>
td{
    border: 1px solid black;
    padding:4px 10px;
    font-size: 14px;
}    th{
    border: 1px solid black;
    padding:4px 10px;
    font-size: 14px;
}
</style>
    <p style="text-align:center;font-size:25px">দরপত্র দাখিল কারীর তালিকা</p>


<table class="table" border="1" style="border-collapse: collapse;width:100%">
<thead>
    <tr>
    <td>দরপত্র নম্বর</td>
    <td>নাম</td>
    <td>পিতার নাম</td>
    <td>ঠিকানা</td>
    <td>মোবাইল</td>
    <td>দরের পরিমাণ</td>
    <td>কথায়</td>
    <td>জামানতের পরিমাণ</td>
    </tr>
</thead>
<tbody>';
        $tenders = Tender::all();
    foreach ($tenders as $application) {


    $html .= " <tr>
        <td>$application->dorId</td>
        <td>$application->applicant_orgName</td>
        <td>$application->applicant_org_fatherName</td>
        <td>গ্রাম- $application->vill, ডাকঘর- $application->postoffice, উপজেলা- $application->thana, জেলা- $application->distric</td>
        <td>$application->mobile</td>
        <td>$application->DorAmount</td>
        <td>$application->DorAmountText</td>
        <td>$application->depositAmount</td>
    </tr>";
}


    $html .= '

</tbody>
</table>



';
   return PdfMaker('A4',$html,'list',false);



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
