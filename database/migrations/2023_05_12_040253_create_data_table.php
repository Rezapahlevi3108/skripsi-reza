<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 6);
            $table->string('nama');
            $table->string('kelas', 3);
            $table->float('sbd');
            $table->float('ips');
            $table->float('ipa');
            $table->float('bing');
            $table->float('mat');
            $table->float('pa');
            $table->float('pjok');
            $table->float('pra');
            $table->float('bind');
            $table->float('pkn');
            $table->integer('cluster');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
