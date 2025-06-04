<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void 
    {
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->date('start_date');
        $table->date('end_date');
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // usuario asignado

        // Nuevos campos
        $table->string('short_description', 100)->nullable();
        $table->enum('priority', ['baja', 'normal', 'urgente'])->default('normal');
        $table->enum('progress', ['sin_empezar', 'en_curso', 'finalizado'])->default('sin_empezar');

        $table->timestamps();
        });
    }


    public function down(): void {
        Schema::dropIfExists('tasks');
    }
};
