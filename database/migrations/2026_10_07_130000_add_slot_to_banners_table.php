<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // null = carrossel do topo; id do grupo (ex: "governanca") = imagem
            // ao lado dessa seção. Ver App\Support\BannerSlots.
            $table->string('slot')->nullable()->after('page');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('slot');
        });
    }
};
