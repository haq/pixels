<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36);
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->string('disk');
            $table->string('path');
            $table->unsignedInteger('duration')->nullable();
            $table->timestamp('converted_for_streaming_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
}
