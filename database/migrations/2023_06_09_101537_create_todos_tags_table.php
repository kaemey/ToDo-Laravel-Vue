<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todos_tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("todo_id");
            $table->string("tag_id");

            $table->index("todo_id", "todo_tag_todo_idx");
            $table->index("tag_id", "todo_tag_tag_idx");

            $table->foreign("todo_id", "todo_tag_todo_fk")->on("todos")->references("id")->onDelete('cascade');
            $table->foreign("tag_id", "todo_tag_tagfk")->on("tags")->references("id")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos_tags');
    }
};