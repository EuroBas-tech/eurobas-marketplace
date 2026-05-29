<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_category_interests', function (Blueprint $table) {
            $table->index(['user_id', 'score'], 'user_category_interests_user_score_index');
            $table->index(['guest_id', 'score'], 'user_category_interests_guest_score_index');
        });
    }

    public function down(): void
    {
        Schema::table('user_category_interests', function (Blueprint $table) {
            $table->dropIndex('user_category_interests_user_score_index');
            $table->dropIndex('user_category_interests_guest_score_index');
        });
    }
};
