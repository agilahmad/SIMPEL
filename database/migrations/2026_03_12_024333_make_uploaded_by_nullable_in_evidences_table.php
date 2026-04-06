<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE evidences DROP CONSTRAINT IF EXISTS evidences_uploaded_by_foreign');
        DB::statement('ALTER TABLE evidences ALTER COLUMN uploaded_by DROP NOT NULL');
        DB::statement('ALTER TABLE evidences ADD CONSTRAINT evidences_uploaded_by_foreign FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL');
    }
};
