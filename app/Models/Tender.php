<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;
    protected $fillable = [
        'dorId',
        'lotNo',
        'applicant_orgName',
        'applicant_org_fatherName',
        'vill',
        'postoffice',
        'thana',
        'distric',
        'mobile',
        'DorAmount',
        'DorAmountText',
        'depositAmount',
        'bank_draft_image',
        'deposit_details',
    ];
}
