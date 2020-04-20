<?php


use PluginMaster\Schema\Schema;

class demo_notes
{
    public function up()
    {
        return Schema::create('demo_notes', function (Schema $column) {
            $column->intIncrements('id');
            $column->integer('user_id')->unsigned()->nullable();
            $column->foreign('user_id')->on('demo_users.id');
            $column->text('note')->nullable();
            $column->enum('status', ['active', 'completed']);
            $column->timestamp('created_at')->default('current_timestamp');
            $column->timestamp('updated_at')->nullable()->onUpdateTimeStamp();
        });
    }

}
