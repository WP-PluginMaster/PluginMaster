PluginMaster (an Application Development Framework for Wordpress)
What is PluginMaster?
« PluginMaster is an Application development framework for WordPress. It changes the flavor of plugin development.»
Code Features
Database Migration System
Simple Side Menu Declaration
Easy Rest API Route Declaration
Query Builder
Simple Enqueue Declaration
Request Handling System
Validator
Build-in Vue JS Configuration
Rest Route & Sidebar Middleware (upcoming)
Documentation
Installation
Clone from "https://github.com/emrancu/PluginMaster" to your plugin directory.
Run "composer dump-autoload" . PluginMaster developer with composer support and psr-4 autoloading. You can use any package using the composer.
If you want to use Vue JS run "npm install" . After installing required node modules run npm run dev for building existing vue JS demo project.
Change your Plugin name, version etc from index.php page in root folder.
Active Plugin from WordPress Plugin Page. A demo project will setup with DemoPlugin side Menu. Demo project builds with Vue JS and Vue Route.

1. Database Migration System
Migrations are typically paired with the PluginMaster schema builder to build your application's database schema. When plugin activates, all migration migrate to the database and when deactivate plugin, all table will be deleted. You just need to define the migration file.
Migration file directory : database/migrations/
 
Structure
The migration file name has 2 parts: first for sequence maintain for foreign key and second for the table name. The migration file name's second part must be the same as table name and also class name will be the same as the table name. File name like 1_demo_users.php. This means, 1 is for sequence maintain and demo_users is the table name and also class name. The table prefix will be set from the schema builder.
A migration class contains one method: up. The up method is used to add new tables to your database.
Sample Migration File
                        
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
                         
                    
Schema Functions
intIncrements($column) : integer (10), auto_increment, primary key
bigIntIncrements($column) : bigint (20), auto_increment, primary key
integer($column, $length = 10) : integer (10)
bigInt($column, $length = 20) : bigint (20)
decimal($column, $length = 20, $places = 2) : decimal (20, 2)
text($column) : text
enum($column, $values) : enum( value, value) ($values must be array).
date($column) : date
timestamp($column) : timestamp
nullable() : NULL
unsigned() : UNSIGNED
default($value) : DEFAULT 'VALUE' (IF $VALUE == 'CURRENT_TIMESTAMP' OR 'current_timestamp' then set CURRENT_TIMESTAMP
onUpdateTimeStamp() : ON UPDATE CURRENT_TIMESTAMP
foreign($column) : make CONSTRAINT for foreign key
on($reference) : $reference means table.column. check following example.
     $column->integer('user_id')->unsigned();
            $column->foreign('user_id')->on('demo_users.id');

2. Simple Side Menu Declaration

Create a WP side menu in easy way. just declare your side nav with controller, method &, etc.
Side Menu declaration file : routes/sidenav.php
Side Menu Controller must declare inside : app/controller/sidenav/
 
 
 
Sample Structure                      
$sidenav->main('DemoPlugin', 
[
"icon" => "dashicons-admin-site", 
 "as" => 'DemoController@main',
 "position" => 500,
 "removeFirstSubmenu" => true
], function ($sidenav) {
       $sidenav->sub('Dashboard', [
"title" => "Dashboard",
 "as" => 'DemoController@sub']);
}); 
                    
The main method has three-parameter.
One : menu slug. (Required)
Two: menu options . Its type must be an array.
Mandatory index: icon (dashboard icon), as ( controller and method must be with @ sign)
Optional index: position (default is 500), removeFirstSubmenu ( for delete first submenu, default false)
Third: closer function for registering submenu under main menu
sub method have two-parameter.
One : menu slug . (Required)
Two : menu options . Its type must be an array.
Mandatory index: title (Menu Title), as ( controller and method must be with @ sign)



 3. Easy Rest API Route Declaration
Create WP rest route in easy way.
Rest Route declaration file : routes/route.php
Rest Route Controller must declare inside : app/controller/api/
Sample Structure
$route->get('dashboard/{id?}', 'DemoController@dashboard');
$route->post('add-note', 'DemoController@addNote');  
                    
DemoController is controller name and dashboard is method name
PluginMaster have two methods for Rest API: GET, POST
Dynamic Parameter : {parameter_name}
Dynamic Optional Parameter : {parameter_name?}
Access Dynamic Param in Controller method : set parameter like : function dashboard($variable) then $variable['id']


4. DB Query Builder
PluginMaster's database query builder provides a convenient, fluent interface to creating and running database queries. It can be used to perform most database operations in your application
Retrieving Results
Retrieving A Single Row
DB::table('users')->first();
Retrieving A multiple Row
DB::table('users')->get();
DB Functions
where($column, $value ) : example:
 
DB::table('users')
     ->where('id', 1)
     ->get()

 
DB::table('users')
     ->where('id', function($query){
       $query->where('id', 1);
       $query->orWhere('name', "emran");
     })
     ->get()
orWhere($column, $value) : DB::table('users')->where('id', 1)->orWhere('name', "emran")->get()
whereRaw($query) : DB::table('users')->whereRaw('id = 1')->first()
orderBy($columns, $direction) : DB::table('users')->orderBy('id,name', "desc")->get()
groupBy($columns) : DB::table('users')->groupBy('id,name')->get()
select($fields) : DB::table('users')->select('id,name')->get()
insert($data) : DB::table('users')->insert(['name' => "demo"])
update($data,$where) : DB::table('users')->update(['name' => "demo"], ["id" => 1]) (will change soon)
delete($where) : DB::table('users')->delete(["id" => 1]) (will change soon)
Join (upcoming)
 
5. Simple Enqueue Declaration
Easy way to add css and js file to application
Enqueue Declaration file : enqueue/enqueue.php
Plugin Deactivation Script Declaration : enqueue/deactiveAction.php
Functions
headerScript($path) : Example : $enqueue->headerScript('assets/js/index.js');
headerScriptCdn($path) : Example : $enqueue->headerScriptCdn('http://alemran.me/js/index.js');
footerScript($path) : Example : $enqueue->footerScript('assets/js/index.js');
footerScriptCdn($path) : Example : $enqueue->footerScriptCdn('http://alemran.me/js/index.js');
style($path) : Example : $enqueue->style('assets/css/style.css');
styleCdn($path) : Example : $enqueue->style('assets/js/index.css');
csrfToken($handler, $objectName): Example :
$enqueue->footerScript('assets/js/index.js','DemoScriptIndex');
$enqueue->csrfToken('DemoScriptIndex','corsData');
$enqueue->hotScript('file_name.js') for Vue JS hot mode (main URL will be http://localhost:8080/file_name.js)
 
6. Request Handling System
Easy way to access request data from native or AJAX
No need isset function to check. just call $request->name , it will return null if not set
Example
 
 use App\system\request\Request;
 $request = new Request();
 echo $request->name;

7. Validator
Validate data is easy in PluginMaster
Example
 
 use App\system\Validator;
 Validator::execute($request, [
            'ID' => 'required|number|limit:10,11',
            'name' => 'required|wordLimit:10,20',
            'slug' => 'required|noSpecialChar',
        ]);










8. Build-in Vue JS Configuration
Build a Vue JS application with your plugin
Configuration:
Configuration file located in the root directory as webpack.config.js.
Vue js files Default directory is : resources/js.
Run : npm run dev. (for development mode)
Run : npm run watch. (for on-change build)
Run : npm run hot. (for on-change build and reload) (default hot mode(webpack dev server) listen from port 8080. if you run this command , you must declare $enqueue->hotScript('file_name.js') in enqueue .
Configuration for Build

 const buildConfig = [
    {
        source: 'resources/js/app.js',
        outputDir: 'assets/js',  // targeted output directory name
        outputFileName: 'app'  // can be with .js extension
    }
];
  
 
OR maybe

 const buildConfig = [
    {
        source: 'resources/js/app.js',
        outputDir: 'assets/js',  // targeted output directory name
        outputFileName: 'app'  // can be with .js extension
    } ,
     {
        source: 'resources/js/nextApp.js',
        outputDir: 'assets/js',  // targeted output directory name
        outputFileName: 'nextApp'  // can be with .js extension
    }];
