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
        Schema::create('pending_rate_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->char('province', 2); // province abbreviation
            $table->decimal('pst', 6, 5); // pst, if applicable
            $table->decimal('gst', 6, 5); // gst rate
            $table->decimal('hst', 6, 5); // hst, if applicable
            $table->decimal('applicable', 6, 5); // applicable tax rate
            $table->string('type'); // type of applicable tax rate
            $table->datetime('start'); // when the rate starts
            $table->text('source'); // source of the information
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_rate_updates');
    }
};
