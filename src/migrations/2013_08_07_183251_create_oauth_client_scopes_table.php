<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthClientScopesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_client_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->integer('scope_id')->unsigned();

            $table->foreign('client_id')
                    ->references('id')->on('oauth_clients')
                    ->onDelete('cascade');

            $table->foreign('scope_id')
                    ->references('id')->on('oauth_scopes')
                    ->onDelete('cascade')
                    ->onUpdate('no action');
            $table->timestamps();
        });

        DB::table('oauth_client_scopes')->insert(
            array(
                'id' => '1',
                'client_id' => '1',
                'scope_id' => '1',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_client_scopes')->insert(
            array(
                'id' => '2',
                'client_id' => '1',
                'scope_id' => '2',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_client_scopes')->insert(
            array(
                'id' => '3',
                'client_id' => '2',
                'scope_id' => '1',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_client_scopes')->insert(
            array(
                'id' => '4',
                'client_id' => 'HYJLQWTWTA',
                'scope_id' => '1',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_client_scopes')->insert(
            array(
                'id' => '5',
                'client_id' => 'DSTEST',
                'scope_id' => '1',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_client_scopes')->insert(
            array(
                'id' => '6',
                'client_id' => 'DSTEST',
                'scope_id' => '2',
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
        Schema::table('oauth_client_scopes', function ($table) {
            $table->dropForeign('oauth_client_scopes_client_id_foreign');
            $table->dropForeign('oauth_client_scopes_scope_id_foreign');
        });
        Schema::drop('oauth_client_scopes');
    }
}
