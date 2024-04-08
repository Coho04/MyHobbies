<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHobbyTagTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('hobby_tag', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Hobby::class)->nullable()->index();
            $table->foreignIdFor(\App\Models\Tag::class)->nullable();
            $table->timestamps();
//            $table->primary(['hobby_id', 'tag_id']);
//            $table->foreign('hobby_id')->references('id')->on('hobbies')->onDelete('cascade');
//            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hobby_tag');
    }
}
