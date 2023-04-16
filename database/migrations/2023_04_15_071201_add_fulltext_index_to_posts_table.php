<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddFulltextIndexToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->text('search_text')->nullable()->after('likes');
        });

        DB::statement('ALTER TABLE posts ADD FULLTEXT fulltext_search(search_text)');

        DB::table('posts')->update([
            'search_text' => DB::raw("CONCAT(title, ' ', body)")
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE posts DROP INDEX fulltext_search');

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('search_text');
        });
    }
}
