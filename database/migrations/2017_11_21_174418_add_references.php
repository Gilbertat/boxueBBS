<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            // 添加外键约束,当user_id 对应的user数据删除后，删除对应的话题
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('replies', function (Blueprint $table) {
            // user 被删除，则删除对应的回复数据
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // topic 被删除，则删除对应的回复数据
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 删除外键约束
        Schema::table('topics', function (Blueprint $table) {
           $table->dropForeign(['user_id']);
        });

        Schema::table('replies', function (Blueprint $table) {
           $table->dropForeign(['user_id']);
           $table->dropForeign(['topic_id']);
        });
    }
}
