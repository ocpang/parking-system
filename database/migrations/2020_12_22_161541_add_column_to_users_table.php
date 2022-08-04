<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('email_token')->nullable()->after('remember_token');
            $table->tinyInteger('status')->nullable()->default(1)->after('email_token');
            $table->unsignedInteger('user_created')->nullable()->default(0)->after('status');
            $table->unsignedInteger('user_updated')->nullable()->default(0)->after('user_created');
            $table->unsignedInteger('user_deleted')->nullable()->default(0)->after('user_updated');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_token');
        });
    }
}
