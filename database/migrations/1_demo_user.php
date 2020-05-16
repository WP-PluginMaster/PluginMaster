<?php

use PluginMaster\Schema\Schema;

class demo_user
{

    public function up()
    {
        return Schema::create('demo_user', function (Schema $column) {
            $column->intIncrements('id');
            $column->string('name')->nullable();
            $column->string('mobile');
            $column->string('email')->nullable();
            $column->text('description')->nullable();
            $column->enum('status', ['ok', 'not']);
            $column->timestamp('student_created_at')->default('current_timestamp')->onUpdateTimeStamp();
        });
    }

}
