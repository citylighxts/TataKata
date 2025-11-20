<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('correction_logs', function (Blueprint $table) {
            $table->id(); 
            $table->text('text'); 
            $table->string('rule_id', 100); 
            $table->text('message'); 
            $table->timestamp('created_at')->useCurrent(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('correction_logs');
    }
};
