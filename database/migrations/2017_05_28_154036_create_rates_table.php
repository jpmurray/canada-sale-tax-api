<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('province'); // province abbreviation
            $table->float('pst', 6, 5)->nullable(); // pst, if applicable
            $table->float('hst', 6, 5)->nullable(); // hst, if applicable
            $table->float('gst', 6, 5)->nullable(); // gst rate
            $table->float('applicable', 6, 5); // applicable tax rate
            $table->string('type'); // type of applicable tax rate, ie: GST+PST
            $table->datetime('start'); // when did that date start
            $table->text('source'); // What is the source of the information
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
