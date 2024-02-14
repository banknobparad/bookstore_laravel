php artisan migrate:refresh --path=/database/migrations/2024_02_14_034441_create_bookcategories_table.php

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
        Schema::create('bookcategories', function (Blueprint $table) {
            $table->id();
            $table->integer('num_book');
            $table->string('name_book');
            $table->string('book')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookcategories');
    }
};
