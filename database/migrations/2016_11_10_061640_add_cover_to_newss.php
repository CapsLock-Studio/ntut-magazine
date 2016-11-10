<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoverToNewss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function(Blueprint $table) {
            $table->string('cover_file_name')->nullable();
            $table->integer('cover_file_size')->nullable()->after('cover_file_name');
            $table->string('cover_content_type')->nullable()->after('cover_file_size');
            $table->timestamp('cover_updated_at')->nullable()->after('cover_content_type');
            $table->boolean('showCover')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function(Blueprint $table) {
            $table->dropColumn('cover_file_name');
            $table->dropColumn('cover_file_size');
            $table->dropColumn('cover_content_type');
            $table->dropColumn('cover_updated_at');
            $table->dropColumn('showCover');
        });
    }
}
