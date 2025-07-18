
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('project_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->timestamps();

            $table->unique(['project_id', 'email']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('project_users');
    }
};
