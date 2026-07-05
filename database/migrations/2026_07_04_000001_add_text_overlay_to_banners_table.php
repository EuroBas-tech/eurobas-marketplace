<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextOverlayToBannersTable extends Migration
{
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('text_position')->default('center')->after('sub_title'); // top / center / bottom
            $table->string('text_size')->default('large')->after('text_position');  // small / medium / large
            $table->string('text_color')->default('white')->after('text_size');     // white / orange / blue / gold
            $table->boolean('show_text')->default(false)->after('text_color');      // true / false
        });
    }

    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['text_position', 'text_size', 'text_color', 'show_text']);
        });
    }
}
