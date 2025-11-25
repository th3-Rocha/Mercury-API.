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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('license_plate', 20);
            $table->string('model', 100);
            $table->string('brand', 100);
            $table->integer('year');
            $table->enum('type', ['truck', 'van', 'car', 'motorcycle'])->default('truck');
            $table->enum('status', ['available', 'in_use', 'maintenance', 'inactive'])->default('available');
            $table->decimal('fuel_capacity', 8, 2);
            $table->decimal('avg_fuel_consumption', 5, 2)->comment('km/l');
            $table->timestamps();

            // Unique por empresa
            $table->unique(['company_id', 'license_plate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
