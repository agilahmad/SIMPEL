<?php

use App\Enums\EvidenceStat;
use App\Enums\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidences', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulidMorphs('evidenceable');
            $table->foreignUlid('uploaded_by')->constrained('users');
            $table->enum('uploader_role', array_column(Role::cases(), 'value'));
            $table->string('file_path');
            $table->string('file_name');
            $table->enum('status', array_column(EvidenceStat::cases(), 'value'))->default(EvidenceStat::Pending->value);
            $table->text('rejection_note')->nullable();
            $table->foreignUlid('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidences');
    }
};
