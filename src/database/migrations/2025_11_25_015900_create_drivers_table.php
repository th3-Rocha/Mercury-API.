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
        Schema::create('drivers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('cpf', 14);
            $table->string('cnh', 20);
            $table->enum('cnh_category', ['A', 'B', 'C', 'D', 'E', 'AB', 'AC', 'AD', 'AE']);
            $table->date('cnh_expiration');
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->decimal('monthly_salary', 10, 2);
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->timestamps();

            // Unique por empresa
            $table->unique(['company_id', 'cpf']);
            $table->unique(['company_id', 'cnh']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
