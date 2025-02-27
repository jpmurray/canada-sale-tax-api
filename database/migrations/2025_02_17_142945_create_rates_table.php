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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->char('province', 2); // province abbreviation
            $table->decimal('pst', 6, 5); // pst, if applicable. 5 total digits, 2 after decimal
            $table->decimal('gst', 6, 5); // gst rate. 5 total digits, 2 after decimal
            $table->decimal('hst', 6, 5); // hst, if applicable, 5 total digits, 2 after decimal
            $table->decimal('applicable', 6, 5); // applicable tax rate. 5 total digits, 2 after decimal
            $table->string('type'); // type of applicable tax rate, comma separated list of types used for the applicable rate
            $table->datetime('start'); // when did that date start
            $table->text('source'); // What is the source of the information
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
