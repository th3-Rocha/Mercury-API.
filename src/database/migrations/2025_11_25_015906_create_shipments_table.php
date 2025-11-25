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
        Schema::create('shipments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignUuid('vehicle_id')->constrained('vehicles')->onDelete('restrict');
            $table->foreignUuid('driver_id')->constrained('drivers')->onDelete('restrict');

            // Informações da entrega
            $table->string('tracking_code', 50)->unique();
            $table->text('origin_address');
            $table->point('origin_location');
            $table->text('destination_address');
            $table->point('destination_location');
            $table->point('current_location')->nullable();

            // Financeiro
            $table->decimal('total_cost', 10, 2);
            $table->decimal('profit', 10, 2);
            $table->decimal('fuel_spent', 10, 2)->default(0.00);
            $table->decimal('fuel_liters', 8, 2)->default(0.00);

            // Status e progresso
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->integer('progress_percentage')->default(0)->comment('0-100');
            $table->decimal('distance_km', 10, 2);
            $table->decimal('distance_completed_km', 10, 2)->default(0.00);

            // Datas
            $table->dateTime('scheduled_date')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('max_delivery_date');

            // Informações adicionais
            $table->text('notes')->nullable();
            $table->json('cargo_details')->nullable();

            $table->timestamps();

            // Índices para otimização
            $table->index('status');
            $table->index('max_delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
