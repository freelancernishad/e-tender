<?php
function month_en_to_bn($month)
{

    $bn_month = array('জানুয়ারি', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগষ্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর');
    $en_month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');


    return str_replace($en_month, $bn_month, $month);
}

function int_en_to_bn($number)
{

    $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $en_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    return str_replace($en_digits, $bn_digits, $number);
}



function sent_response($message,$data=[]){
    $response = [
        'status'=>true,
        'message'=>$message,
        'data'=>$data,
    ];
    return response()->json([$response]);

}

function sent_error($message ,$messages=[],$code=404){
    $response = [
        'status'=>false,
        'message'=>$message,
        'code'=>$code
    ];
    !empty($messages) ? $response['errors'] = $messages : null;


    return response()->json(['response'=>$response],$code);

}



use Stichoza\GoogleTranslate\GoogleTranslate;

function transition($text)
{





    if(session()->has('lan')){
            $tr = new GoogleTranslate(session('lan')); // Translates into English
    }else{
        $tr = new GoogleTranslate('en'); // Translates into English
    }
    return $tr->translate($text);
}

function transitionsingle($text,$lan)
{
    $tr = new GoogleTranslate($lan); // Translates into English
    return $tr->translate($text);
}
