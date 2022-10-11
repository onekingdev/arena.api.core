<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenreFieldsToArtistsGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("artists_genres", function (Blueprint $table) {
            $table->unsignedBigInteger("genre_id")->index("idx_genre-id")->after("artist_uuid");
            $table->uuid("genre_uuid")->index("idx_genre-uuid")->after("genre_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("artists_genres", function (Blueprint $table) {
            $table->dropColumn(["genre_id", "genre_uuid"]);
        });
    }
}
