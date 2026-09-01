<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // e.g. "Inside Dhaka"
            $table->string('name_bn')->nullable();
            $table->decimal('fee', 10, 2)->default(0);
            $table->decimal('free_delivery_threshold', 10, 2)->nullable();
            $table->unsignedInteger('estimated_days_min')->default(1);
            $table->unsignedInteger('estimated_days_max')->default(3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_zones');
    }
};
