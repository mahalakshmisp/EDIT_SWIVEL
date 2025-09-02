<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->string('author_name');
            $table->text('author_description');
            $table->text('course_description');
            $table->unsignedBigInteger('category_id');
            $table->string('video_path');
            $table->decimal('price', 8, 2);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
