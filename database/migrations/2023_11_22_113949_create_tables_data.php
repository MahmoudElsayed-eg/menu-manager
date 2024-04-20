<?php

use App\Models\Table;
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
        Schema::create('tableData', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amount');
            $table->string('barcode');
            $table->boolean('printed')->default(false);
            $table->foreignIdFor(Table::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tableData');
    }
};
