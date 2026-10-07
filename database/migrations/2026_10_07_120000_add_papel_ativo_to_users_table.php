<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('papel', 20)->default('editor');  // admin ou editor
            $table->boolean('ativo')->default(true);
            $table->timestamp('ultimo_login')->nullable();
        });

        // ate agora so existia o admin, entao quem ja esta no banco continua admin
        DB::table('users')->update(['papel' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['papel', 'ativo', 'ultimo_login']);
        });
    }
};
