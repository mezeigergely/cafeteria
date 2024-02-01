<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cafeteria_plans', function (Blueprint $table) {
            $table->id();
            $table->json('pockets_budget_annual');
            $table->json('pockets_budget_monthly');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cafeteria_plans');
    }
};
