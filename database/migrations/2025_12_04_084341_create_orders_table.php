<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->decimal('discount', 20, 2)
                ->default(0)
                ->comment('in amount or rupiah');
            $table->timestamp('scheduled_at');
            $table
                ->enum('status', ['scheduled', 'inprogress', 'rescheduled', 'cancelled', 'done'])
                ->default('scheduled');
            $table->text('address')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
