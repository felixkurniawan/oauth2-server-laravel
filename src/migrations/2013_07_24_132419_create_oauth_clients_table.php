<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthClientsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_clients', function (Blueprint $table) {
            $table->string('id', 40);
            $table->string('secret', 40);
            $table->string('name');
            $table->timestamps();

            $table->unique('id');
            $table->unique(array('id', 'secret'));
        });

        DB::table('oauth_clients')->insert(
            array(
                'id' => '1',
                'secret' => '001',
                'name' => '001',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_clients')->insert(
            array(
                'id' => '2',
                'secret' => '002',
                'name' => 'Reduxus Maximus',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_clients')->insert(
            array(
                'id' => 'DSTEST',
                'secret' => 'dstest_secret',
                'name' => 'DeepsSea RAML Console Client',
                'created_at' => '2014-02-06',
                'updated_at' => '2014-02-06'
            )
        );
        DB::table('oauth_clients')->insert(
            array(
                'id' => 'HYJLQWTWTA',
                'secret' => '5197CBGFRCMF8XPZ',
                'name' => 'GDP Labs Test Apps',
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
        Schema::drop('oauth_clients');
    }
}
