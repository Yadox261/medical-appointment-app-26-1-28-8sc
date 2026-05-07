<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')
                ->constrained('consultations')
                ->onDelete('cascade');
            $table->string('medication')->comment('Nombre del medicamento');
            $table->string('dose')->comment('Dosis del medicamento');
            $table->string('frequency')->nullable()->comment('Frecuencia y duración del tratamiento');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
