<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use WHMCS\Database\Capsule;

class CreateModIdtTldSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('mod_idt_tld_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tld');
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Capsule::schema()->drop('mod_idt_tld_settings');
    }
}
