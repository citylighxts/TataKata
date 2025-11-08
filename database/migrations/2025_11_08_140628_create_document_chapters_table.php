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
        Schema::create('document_chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->string('chapter_title');
            $table->integer('chapter_order')->default(0);
            $table->longText('original_text')->nullable();
            $table->longText('corrected_text')->nullable();
            $table->string('status')->default('Pending'); // Pending, Processing, Completed, Failed
            $table->text('details')->nullable(); // Untuk pesan error
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_chapters');
    }
};