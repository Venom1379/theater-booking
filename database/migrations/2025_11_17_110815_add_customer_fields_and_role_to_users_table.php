<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('users', function (Blueprint $table) {

        // ====== ROLE FIELD ======
        $table->string('role')->default('customer'); 
        // possible values: admin, manager, organisation, customer

        // ====== CUSTOMER FIELDS ======
        $table->string('organisation_name')->nullable();
        $table->string('phone_number', 20)->nullable();
        $table->string('whatsapp_number', 20)->nullable();
        $table->string('address_line_1')->nullable();
        $table->string('address_line_2')->nullable();
        $table->string('aadhar_number', 20)->nullable();
        $table->string('aadhar_document', 500)->nullable();
        $table->string('registration_document', 500)->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'role',
            'organisation_name',
            'phone_number',
            'whatsapp_number',
            'address_line_1',
            'address_line_2',
            'aadhar_number',
            'aadhar_document',
            'registration_document'
        ]);
    });
}

};
