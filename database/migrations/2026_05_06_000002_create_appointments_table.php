<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->onDelete('cascade');
            $table->foreignId('doctor_id')
                ->constrained('doctors')
                ->onDelete('cascade');
            $table->date('date')->comment('Fecha de la cita');
            $table->time('start_time')->comment('Hora de inicio de la cita');
            $table->time('end_time')->comment('Hora de fin de la cita');
            $table->integer('duration')->default(15)->comment('Duración de la cita en minutos');
            $table->text('reason')->nullable()->comment('Motivo de la cita');
            $table->tinyInteger('status')->default(1)->comment('1=Programado, 2=Completado, 3=Cancelado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
