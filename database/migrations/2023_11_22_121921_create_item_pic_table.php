<?php

use App\Models\CategoryData;
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
        Schema::create('itemPics', function (Blueprint $table) {
            $table->id();
            $table->string('pic');
            $table->string('barcode');
            $table->foreignIdFor(CategoryData::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemPics');
    }
};
