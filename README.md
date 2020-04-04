# PluginMaster (an Application Development Framework for Wordpress)
# What is PluginMaster?
  <blockquote>
    « PluginMaster is an Application development framework for WordPress. It changes the flavor of plugin development.»
  </blockquote>

# Code Features   
 <ol type="1">
 <li> Database Migration System</li>
 <li> Simple Side Menu Declaration</li>
<li> Easy Rest API Route Declaration</li>
<li> Query Builder </li>
<li> Simple Enqueue Declaration  </li>
<li> Request Handling System  </li>
<li> Validator  </li>
<li> Build-in Vue JS Configuration  </li>
<li> Rest Route & Sidebar Middleware (upcoming)  </li>
</ol>

# Installation 
<ol>
<li>  Clone from <code>"https://github.com/emrancu/PluginMaster"</code> to your plugin directory.  </li>
<li>  Run <code>"composer dump-autoload"</code> . PluginMaster developer with <code>composer</code> support and <code>psr-4</code> autoloading. You can use any package using the composer. </li>
<li> If you want to use Vue JS run <code>"npm install"</code> . After installing required node modules run  <code>npm run dev</code> for building existing vue JS demo project. </li>
<li> Change your Plugin name, version etc from <code>index.php</code> page in root folder.  </li>
<li> Active Plugin from WordPress Plugin Page. A demo project will setup with <code>DemoPlugin</code> side Menu. Demo project builds with Vue JS and Vue Route.  </li>
</ol>


# Database Migration System

<p> Migrations are typically paired with the <b>PluginMaster</b> schema builder to build your application's database schema. When plugin activates, all migration migrate to the database and when deactivate plugin, all table will be deleted. You just need to define the migration file.  </p>
 <b>Migration file directory : <code>database/migrations/</code></b>
 
 <b>Structure</b> 
 
 <p>The migration file name has 2 parts : first for sequence maintain for foreign key and second for the table name. The migration file name's second part must be the same as table name and also class name will be the same as the table name. File name like : <code>1_demo_users.php</code>. This means, <code>1</code> is for sequence maintain and <code>demo_users</code> is the table name and also class name. the table prefix will be set from the schema builder.</p>
<p>A migration class contains one method: up. The up method is used to add new tables  to your database.</p>
<b>Sample Migration File</b>
<pre>
<code>
<?php

use App\system\schema\Schema;

class demo_users
{
    public function up()
    {
      return Schema::create('demo_users', function (Schema $column) {
            $column->intIncrements('id');
            $column->string('name')->nullable() ;
            $column->string('mobile') ;
            $column->string('email')->nullable();
            $column->text('description')->nullable();
            $column->enum('status', ['ok', 'not']);
            $column->timestamp('student_created_at')->default('current_timestamp')->onUpdateTimeStamp();
        });
    }

}
 </code>
 </pre>




