<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->string('subject');
            $table->enum('status', ['open', 'close'])->default('open');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->index('user_id', 'idx_tickets_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
