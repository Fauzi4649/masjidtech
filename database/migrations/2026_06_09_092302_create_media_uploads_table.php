<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_type');
            $table->string('file_path');
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('announcement_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_uploads');
    }
};