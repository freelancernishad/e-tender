<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('applicant_orgName')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('depositAmount')->nullable();
            $table->string('amount')->nullable();
            $table->string('bank_draft_image')->nullable();
            $table->string('deposit_details')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenders');
    }
}
