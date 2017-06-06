<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_activity_log', function (Blueprint $table) {
            $table->datetime('datetime');
            $table->ipAddress('ip_address');
            $table->string('username');
            $table->string('origin');
            $table->string('event');
            $table->string('description');

            $table->engine = 'Archive';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_activity_log');
    }
}
