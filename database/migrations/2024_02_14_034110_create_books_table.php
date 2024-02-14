php artisan migrate:refresh --path=/database/migrations/2024_02_14_034110_create_books_table.php
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->integer('ctgy_book');
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->text('detail')->nullable();
            $table->string('image')->nullable();
            $table->double('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
