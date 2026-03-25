<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bloodtypes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 5)->unique()->comment('Nombre del tipo de sangre');
            $table->enum('abo_group', ['A', 'B', 'AB', 'O'])->index();
            $table->enum('rh_factor', ['+', '-']);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bloodtypes');
    }
};