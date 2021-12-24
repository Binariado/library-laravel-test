<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->string('book_archive');
            $table->string('name');
            $table->foreignId('author_id')->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('editor_id')->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('publisher_id')->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('gender_id')->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamp('date_of_publication');
            $table->integer('number_page');
            $table->text('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libraries');
    }
}
