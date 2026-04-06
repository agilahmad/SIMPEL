<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_report_stagings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('ticket_code')->unique();
            $table->string('application_name')->nullable();
            $table->string('vulnerability_name');
            $table->string('severity');
            $table->date('reporting_date');
            $table->string('reporter_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->enum('status', ['pending', 'saved', 'rejected'])->default('pending');
            $table->ulid('saved_as_incident_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_report');
    }
};
