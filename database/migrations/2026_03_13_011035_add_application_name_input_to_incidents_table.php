<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->string('application_name_input')->nullable()->after('application_id');
        });

        DB::statement('ALTER TABLE incidents DROP CONSTRAINT IF EXISTS incidents_application_id_foreign');
        DB::statement('ALTER TABLE incidents ALTER COLUMN application_id DROP NOT NULL');
        DB::statement('ALTER TABLE incidents ADD CONSTRAINT incidents_application_id_foreign FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE SET NULL');
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn('application_name_input');
        });
    }
};
