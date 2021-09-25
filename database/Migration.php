<?php

namespace PluginMaster\Database;

use PluginMaster\Contracts\Database\MigrationInterface;
use PluginMaster\Schema\Schema;

class Migration implements MigrationInterface
{

    /**
     * execute your schema here
     * or call class where you execute schema
     */
    public static function handler() {

        Schema::create( 'demo_notes', function ( Schema $column ) {
            $column->intIncrements( 'id' );
            $column->integer( 'user_id' ) ;
            $column->text( 'note' )->nullable();
            $column->enum( 'status', [ 'active', 'completed' ] );
            $column->timestamp( 'created_at' )->default( 'current_timestamp' );
            $column->timestamp( 'updated_at' )->nullable()->onUpdateTimeStamp();
        } )->execute();


    }

}
