<?php

use App\Models\Category;
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
        Schema::create('categoryData', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class);
            $table->string('barcode');
            $table->unsignedBigInteger('position')->default(0);
            $table->unsignedBigInteger('key_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoryData');
    }
};
