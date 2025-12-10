<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $exists = DB::select("
            SELECT 1
            FROM pg_type
            WHERE typname = 'ticket_status'
        ");

        if (empty($exists)) {
            DB::statement("CREATE TYPE ticket_status AS ENUM ('open', 'close');");
        }

        $exists = DB::select("
            SELECT 1
            FROM pg_type
            WHERE typname = 'message_sender'
        ");

        if (empty($exists)) {
            DB::statement("CREATE TYPE message_sender AS ENUM ('user', 'admin');");
        }
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS ticket_status CASCADE;");
        DB::statement("DROP TYPE IF EXISTS message_sender CASCADE;");
    }
};
