<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacacions', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->decimal('precio_pp', 10, 2); // Precio por persona
            $table->foreignId('tipo_id')->constrained('tipos')->onDelete('cascade');
            $table->string('fotos')->nullable(); // Keeping likely for compatibility or legacy reasons as per prompt
            $table->string('pais');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacacions');
    }
};
