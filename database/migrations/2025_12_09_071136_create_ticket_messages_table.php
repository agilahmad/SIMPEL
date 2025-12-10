<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->enum('sender', ['user', 'admin']);
            $table->text('message');
            $table->timestamps();
        });

        Schema::table('ticket_messages', function (Blueprint $table) {
            $table->index('ticket_id', 'idx_ticket_messages_ticket_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_messages');
    }
};
