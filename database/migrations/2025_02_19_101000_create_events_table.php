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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('location');
            $table->unsignedBigInteger("category_id");
            $table->foreign("category_id")->references("id")->on("categories")->onDelete('cascade');
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->dateTime("begin_at");
            $table->unsignedBigInteger("max_participants");
            $table->timestamps();
            $table->boolean("is_deleted")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
