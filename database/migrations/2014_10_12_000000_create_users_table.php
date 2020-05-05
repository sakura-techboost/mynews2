<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     /* php artisan migrateを実行したときに呼ばれる関数 */
    public function up()
    {
        /* usersという名前のテーブル(箱)を作成する。中身は以下の通り */
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            /* 一回ログインしていた場合、次回自動ログインしてくれる */
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     /* php artisan migrate:rollbackを実行したときに呼ばれる関数 */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

