<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commerces', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('idUser');
                $table->string('tradeName');
                $table->string('cif')->unique();
                $table->longtext('address');
                $table->longtext('province');
                $table->string('country');
                $table->string('zipcode');
                $table->string('phone');
                $table->string('email');
                $table->string('avatar')->nullable();
                $table->char('email_verified')->nullable();
                $table->integer('status')->default(0);
                $table->char('active')->default(1);
                $table->integer('rate')->default(100);
                $table->integer('type')->default(0);
                $table->bigInteger('lastUserWhoModifiedTheField');
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
        Schema::dropIfExists('commerces');
    }
}
