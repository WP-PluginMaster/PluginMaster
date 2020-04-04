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
<li>If you want to build vue (Build app is available with PluginMaster) run <code>"npm install"</code> . After installing required node modules run  <code>npm run dev</code> for building existing vue JS demo project. </li>
<li> Change your Plugin name, version etc from <code>index.php</code> page in root folder.  </li>
<li> Active Plugin from WordPress Plugin Page. A demo project will setup with <code>DemoPlugin</code> side Menu. Demo project builds with Vue JS and Vue Route.  </li>
  <li> Change api_namespace from <code> app/config/config.php</code> if needed</li>
</ol>

# 1. Database Migration System

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

# Schema Functions 
 <ol>
<li> <code>intIncrements($column)</code> : integer (10), auto_increment, primary key </li>
<li> <code>bigIntIncrements($column)</code> : bigint (20), auto_increment, primary key </li>
<li> <code>integer($column, $length = 10)</code> : integer (10)  </li>
<li> <code>bigInt($column, $length = 20)</code> : bigint (20)  </li>
<li> <code>decimal($column, $length = 20, $places = 2)</code> : decimal (20, 2)  </li>
<li> <code>text($column)</code> : text </li>
<li> <code>enum($column, $values)</code> : enum( value, value) ($values must be array).  </li>
<li> <code>date($column)</code> : date  </li>
<li> <code>timestamp($column)</code> : timestamp  </li>
<li> <code> nullable() </code> : NULL  </li>
<li> <code> unsigned() </code> : UNSIGNED  </li>
<li> <code> default($value)</code> : DEFAULT 'VALUE' (IF $VALUE == 'CURRENT_TIMESTAMP' OR 'current_timestamp' then set <code>CURRENT_TIMESTAMP </code></li>
<li> <code> onUpdateTimeStamp()</code> : ON UPDATE CURRENT_TIMESTAMP  </li>
<li> <code> foreign($column)</code> : make CONSTRAINT for foreign key  </li>
<li> <code> on($reference)</code> : $reference means table.column. check following example.
<pre>
<code>    
$column->integer('user_id')->unsigned();
$column->foreign('user_id')->on('demo_users.id'); </code>
</pre>

</li>
</ol>


# 2. Simple Side Menu Declaration 


<p>Create a WP side menu in easy way. just declare your side nav with controller, method &, etc.   </p>
<b> Side Menu declaration file : routes/sidenav.php </b><br>
<b> Side Menu Controller must declare inside : app/controller/sidenav/ </b>
<p class="mt-3"><b>Sample Structure</b></p>
<pre>
<code>
$sidenav->main('DemoPlugin', ["icon" => "dashicons-admin-site",  "as" => 'DemoController@main', "position" => 500, "removeFirstSubmenu" => true], function ($sidenav) {
    $sidenav->sub('Dashboard', ["title" => "Dashboard", "as" => 'DemoController@sub']);
}); 
</code>
 </pre>
 <p class="mt-2"><b>The <code>main method </code> has   three parameters..</b>  </p>
<ol>
<li>One : menu slug . (Required)</li>
<li>Two : menu options . Its type must be an array. <br>
<b>Mandatory index:</b>  icon (dashboard icon), as ( controller and method must be with <code>@</code> sign) <br>
<b>Optional index:</b>  position (default is 500),  removeFirstSubmenu ( for delete first submenu, default false) <br>
</li>
 <li>Third: closer function for registering submenu under main menu</li>
</ol>
<p class="mt-4"><b>The <code>sub method </code> has two parameters.</b>  </p>
<ol>
<li>One : menu slug . (Required)</li>
<li>Two : menu options . Its type must be an array. <br>
<b>Mandatory index:</b>  title (Menu Title), as ( controller and method must be with <code>@</code> sign) <br>
</li>
 </ol>
 
 
 
 
 # 3. Easy Rest API Route Declaration
 
 
  <p>Create WP rest route in easy way.     </p>
  <p> <b> Rest Route declaration file : routes/route.php </b><br> <b> Rest Route Controller must declare inside : app/controller/api/ </b></p>
<p class="mt-3"><b>Sample Structure</b></p>
<pre><code>
$route->get('dashboard/{id?}', 'DemoController@dashboard');
$route->post('add-note', 'DemoController@addNote'); 
</code>
</pre>
<span><code>DemoController</code> is controller name and <code>dashboard</code> is method name</span>
<p class="mt-2"><b> PluginMaster have two method: GET, POST   </b>  </p>
<ol>
 <li>Dynamic Parameter : <code>{parameter_name}</code></li>
<li>Dynamic Optional Parameter : <code>{parameter_name?} </code></li>
<li> Access Dynamic Param in Controller method : set parameter like : <code>function dashboard($variable)</code> then <code>$variable['id'] </code></li>
</ol>
 
 
 
 
 
 # 4. DB Query Builder
 
 
 
 
 <p>PluginMaster's database query builder provides a convenient, fluent interface to creating and running database queries. It can be used to perform most database operations in your application </p>
# Retrieving Results 
<ol>
<li><b>  Retrieving A Single Row </b><br><code>  DB::table('users')->first();</code></li>
<li><b>  Retrieving A multiple Row </b><br><code>  DB::table('users')->get();</code></li>
</ol>
# DB Functions 
<ol>
<li> <code>where($column, $value )</code> :
                                example:
<pre> <code>
DB::table('users')
     ->where('id', 1)
     ->get()
 </code></pre>
<pre> <code>
DB::table('users')
     ->where('id', function($query){
       $query->where('id', 1);
       $query->orWhere('name', "emran");
     })
     ->get()
 </code></pre>
</li>
<li> <code>orWhere($column, $value)</code> : <code>DB::table('users')->where('id', 1)->orWhere('name', "emran")->get()</code>   </li>
<li> <code>whereRaw($query)</code> : <code>DB::table('users')->whereRaw('id = 1')->first()</code>   </li>
<li> <code>orderBy($columns, $direction)</code> : <code>DB::table('users')->orderBy('id,name', "desc")->get()</code>   </li>
<li> <code>groupBy($columns)</code> : <code>DB::table('users')->groupBy('id,name')->get()</code>   </li>
<li> <code>select($fields)</code> : <code>DB::table('users')->select('id,name')->get()</code>   </li>
<li> <code>insert($data)</code> : <code>DB::table('users')->insert(['name' => "demo"])</code>   </li>
<li> <code>update($data,$where)</code> : <code>DB::table('users')->update(['name' => "demo"], ["id" => 1])</code> (will change soon)  </li>
 <li> <code>delete($where)</code> : <code>DB::table('users')->delete(["id" => 1])</code> (will change soon)  </li>
<li> Join (upcoming)   </li>
</ol>



# 5. Simple Enqueue Declaration 


 <p> Easy way to add css and js file to application</p>
<b> Enqueue Declaration file : enqueue/enqueue.php </b><br>
<b>Plugin Deactivation Script Declaration : enqueue/deactiveAction.php </b>
<p class="mt-3"><b>Functions</b></p>
<ol>
<li><code>  headerScript($path) :  </code> Example : <code>$enqueue->headerScript('assets/js/index.js');</code> </li>
<li><code>  headerScriptCdn($path) :  </code> Example : <code>$enqueue->headerScriptCdn('http://alemran.me/js/index.js');</code> </li>
<li><code>  footerScript($path) :  </code> Example : <code>$enqueue->footerScript('assets/js/index.js');</code> </li>
<li><code>  footerScriptCdn($path) :  </code> Example : <code>$enqueue->footerScriptCdn('http://alemran.me/js/index.js');</code> </li>
<li><code>  style($path) :  </code> Example : <code>$enqueue->style('assets/css/style.css');</code> </li>
<li><code>  styleCdn($path) :  </code> Example : <code>$enqueue->style('assets/js/index.css');</code> </li>
<li><code> csrfToken($handler, $objectName):  </code> Example :

<pre>
  <code>
$enqueue->footerScript('assets/js/index.js','DemoScriptIndex');
$enqueue->csrfToken('DemoScriptIndex','corsData');
</code>
</pre>
</li>

<li><code>   $enqueue->hotScript('file_name.js')  </code> for Vue JS hot mode (main url will be <code> http://localhost:8080/file_name.js</code>)</li>
</ol>



# 6. Request Handling System


<p> Easy way to  access request data from native or AJAX</p>
  <b> No need isset function to check. just call <code>$request->name</code> , it will return null if not set </b><br>
 <p class="mt-3"><b>Example</b></p>

 <pre>
 <code>
 use App\system\request\Request;
 $request = new Request();
 echo $request->name;
</code>
</pre>



# 7. Validator 


<p> Validate data is easy in PluginMaster</p>
 <p class="mt-3"><b>Example</b></p>

<pre>
<code>
 use App\system\Validator;
 Validator::execute($request, [
            'ID' => 'required|number|limit:10,11',
            'name' => 'required|wordLimit:10,20',
            'slug' => 'required|noSpecialChar',
        ]);

</code>
</pre>
 <p>if validation fail then return and exit with :</p>
<pre> <code>
  return  json( [
        "status" => $status,
        "message" => "Please check required field",
        "errors" => self::$message
    ], 401);
 </code></pre>
 # Available Validation: 
<ol>
<li>required</li>
 <li>mobile (start with zero and must be in 0-9)</li>
<li>number</li>
<li>floatNumber</li>
<li>noNumber( accept all character without number)</li>
<li>letter( accept only letter :A-Za-z))</li>
<li>noSpecialChar </li>
<li>limit: min, max </li>
<li>wordLimit: min, max </li>
<li>email </li>
</ol>


# 8. Build in Vue JS Configuration 

 <p>  Build Vue JS application with your plugin</p>
 <p class="mt-3"><b>Configuration</b></p>
 <p> Configuration file located in root directory as <code>webpack.config.js</code>. </p>
 <p> <b> Vue js files Default directory is : <code>resources/js</code></b>. </p>
<p> <b> Run  : <code>npm run dev</code></b>. (for development mode)</p>
<p> <b> Run  : <code>npm run watch</code></b>. (for on-change build)</p>
<p> <b> Run  : <code>npm run hot</code></b>. (for on-change build and reload) (default hot mode(webpack dev server) listen from port 8080. if you run this command , you must declare   <code>$enqueue->hotScript('file_name.js') </code> in enqueue .</p>
<p>Configuration for Build</p>
<pre>
 <code>
 const buildConfig = [
    {
        source: 'resources/js/app.js',
        outputDir: 'assets/js',  // targeted output directory name
        outputFileName: 'app'  // can be with .js extension
    }
];
  </code>
  </pre>
# OR may be
 <pre>
 <code>
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
    }
];
  </code>
  </pre>
                    
 
 # 9. Global Functions
 
 <ol>
  <li><code>view()</code> : root of vue file : <code>resources/view/</code>. you have to pass only file name withour extention and directory. Example: <code> view('home/index') </code> </li>
  <li> <code> json($data, $code)</code> : for returnning as json with status code</li> 
  
  <li> <code> config($key)</code> : for returnning configuration data. you can set/ change  configuration data from : <code>add/config/config.php</code></li>
  

  
  </ol>
                    


# License
<p>The MIT License (MIT)</p>

<p>Developed by : <a href="https://alemran.me">AL EMRAN</a></p>
