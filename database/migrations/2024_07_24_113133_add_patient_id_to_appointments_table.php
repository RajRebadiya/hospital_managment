<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            //
            // $table->unsignedBigInteger('patient_id'); // Add patient_id column
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null'); // Foreign key constraint
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            //
            $table->dropForeign(['patient_id']);
            $table->dropColumn('patient_id');
        });
    }
};
