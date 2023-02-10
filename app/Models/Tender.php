<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'applicant_orgName',
        'address',
        'mobile',
        'depositAmount',
        'amount',
        'bank_draft_image',
        'deposit_details',
    ];
}
