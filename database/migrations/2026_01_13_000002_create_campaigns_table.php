<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundraiser_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('report_id')->nullable()->constrained('reports')->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('target_amount', 24, 2);
            $table->decimal('collected_amount', 24, 2)->default(0);
            $table->date('deadline');
            $table->boolean('is_verified')->default(false);
            $table->enum('status', ['pending', 'active', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
