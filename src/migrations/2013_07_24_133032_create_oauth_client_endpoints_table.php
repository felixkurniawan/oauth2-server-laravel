<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthClientEndpointsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_client_endpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->string('redirect_uri');

            $table->timestamps();

            $table->foreign('client_id')
                    ->references('id')->on('oauth_clients')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

        });

        DB::table('oauth_client_endpoints')->insert(
            array(
                'id' => '1',
                'client_id' => '1',
                'redirect_uri' => 'http://localhost/web/auth.php',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_client_endpoints')->insert(
            array(
                'id' => '2',
                'client_id' => '2',
                'redirect_uri' => 'http://sa.deepsea.local/channel.html',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_client_endpoints')->insert(
            array(
                'id' => '3',
                'client_id' => 'HYJLQWTWTA',
                'redirect_uri' => 'http://localhost/jsapi/channel.html',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_client_endpoints')->insert(
            array(
                'id' => '4',
                'client_id' => 'DSTEST',
                'redirect_uri' => 'http://103.29.150.136/authentication/oauth2.html',
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
        Schema::table('oauth_client_endpoints', function ($table) {
            $table->dropForeign('oauth_client_endpoints_client_id_foreign');
        });
        
        Schema::drop('oauth_client_endpoints');
    }
}
