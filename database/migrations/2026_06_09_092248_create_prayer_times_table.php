<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_times', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Subuh, Syuruk, Zohor, Asr, Maghrib, Isyak
            $table->time('adhan_time');
            $table->time('iqama_time')->nullable();
            $table->date('effective_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_times');
    }
};