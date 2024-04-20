<?php

use App\Models\Zone;
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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Zone::class);
            $table->unsignedBigInteger('numPersons')->default(0);
            $table->unsignedBigInteger('numChairs')->default(0);
            $table->float('x')->default(0);
            $table->float('y')->default(0);
            $table->unsignedBigInteger('width')->default(20);
            $table->unsignedBigInteger('height')->default(20);
            $table->string('tablecolor')->default("#ac8a68");
            $table->string('textcolor')->default('#ffffff');
            $table->boolean('round')->default(false);
            $table->softDeletes();
            $table->unsignedBigInteger('merged')->nullable();
            $table->enum('status',['فارغ','محجوز','مشغول'])->default('فارغ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
