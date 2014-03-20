<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthScopesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_scopes', function (Blueprint $table) {

            $table->increments('id');
            $table->string('scope')->unique();
            $table->string('name');
            $table->string('description');

            $table->timestamps();
        });

        DB::table('oauth_scopes')->insert(
            array(
                'id' => '1',
                'scope' => 'all',
                'name' => 'all',
                'description' => 'Enable All',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_scopes')->insert(
            array(
                'id' => '2',
                'scope' => 'limited',
                'name' => 'limited',
                'description' => 'Limited Access',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_scopes')->insert(
            array(
                'id' => '3',
                'scope' => 'internal',
                'name' => 'internal',
                'description' => 'Internal Access',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oauth_scopes');
    }
}
