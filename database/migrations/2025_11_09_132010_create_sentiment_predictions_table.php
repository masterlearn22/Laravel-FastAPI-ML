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
        Schema::create('sentiment_predictions', function (Blueprint $table) {
            $table->id();
            $table->text('text');              // input teks yang dianalisis
            $table->string('label');           // positive / negative
            $table->float('confidence');       // nilai confidence dari FastAPI
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentiment_predictions');
    }
};
