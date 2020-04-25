# PluginMaster (an Application Development Framework for WordPress)
# What is PluginMaster?
  <blockquote>
    « PluginMaster is an Application development framework for WordPress. It changes the flavor of plugin development.»
  </blockquote>

# Code Features   
 <ol type="1">
<li> <a href="#DatabaseMigrationSystem"> Database Migration System </a></li>
 <li><a href="#SimpleSideMenuDeclaration">  Simple Side Menu Declaration</a></li>
<li><a href="#EasyRestAPIRouteDeclaration">  Simple Rest API Declaration</a></li>
<li><a href="#QueryBuilder">   Database Query Builder</a></li>
<li><a href="#SimpleEnqueueDeclaration">  Simple Enqueue Declaration</a></li>
<li><a href="#ShortCode"> Easy Shortcode Handler </a></li>
<li><a href="#RequestHandlingSystem">  Http Request Handling </a></li>
<li><a href="#Validator">  Request Validation</a></li> 
<li><a href="#BuildinVueJSConfiguration">  Build-in Vue JS Configuration</a></li>
<li><a href="#GlobalFunction">  Global Functions </a></li>
<li><a href="#SessionHandler">  Session Handler </a></li>
<li> Middleware (upcoming) </li> 
<li> Action Handler (upcoming) </li>
<li> Filter Handler (upcoming)  </li>
</ol>

# Installation 
 <ol> 
 <li>Go to <code>wp-content/plugins/</code> directory in your WordPress</li>
 <li>Open terminal and run : <code>composer create-project plugin-master/plugin-master</code> <b>OR</b> <code>composer
                            create-project plugin-master/plugin-master project_name</code></li>
 <li> A demo application includes with Vue JS . Just active from Plugin section</li>
 
</ol>
# Configuration 
<ol> 
 <li> Change your Plugin name, version etc from <code>index.php</code> page in root folder.</li>
 <li>Change Rest API Namespace from <code>config.php</code>, located in <code>app/config/</code>
                        directory (You can add any configuration related data in <code>config.php </code>)
                    </li>
 
 </ol>

# 1. Database Migration System
 <div id="DatabaseMigrationSystem"></div>

<p> Migrations are typically paired with the <b>PluginMaster</b> schema builder to build your application's database schema. When plugin activates, all migration migrate to the database and when deactivate plugin, all table will be deleted. You just need to define the migration file.  </p>
 <b>Migration file directory : <code>database/migrations/</code></b>
 
 <b>Structure</b> 
 
<p>The migration file name has 2 parts :
 <ol>
 <li><b>First</b>  for sequence maintain for foreign key and <b>second</b> for the  table name.  <b> Second </b> part must be the same as table name .</li>
</ol>
 <blockquote>  Also class name will be the same as the table name.<br> File name like : <code>1_demo_users.php</code>.
                This means, <code>1</code> is for sequence maintain and <code>demo_users</code> is the table name and also class
                name. the table prefix will be set from the schema builder.
 </blockquote>

<p>A migration class contains one method: up. The up method is used to add new tables to your database.</p>
 <b>Sample Migration File</b>
 <p class="mt-3">File Name: <code>1_demo_users.php</code></p>

<pre><code>
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
            $column->integer('user_id')->unsigned()->nullable();
            $column->foreign('user_id')->on('demo_users.id');
            $column->timestamp('student_created_at')->default('current_timestamp')->onUpdateTimeStamp();
        });
    }

}
 </code>
 </pre>

<b>Schema Functions </b>
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
<li> <code>nullable() </code> : null  </li>
<li> <code>unsigned() </code> : unsigned  </li>
<li> <code>default($value)</code> : default 'value' (if $value == 'CURRENT_TIMESTAMP' OR 'current_timestamp' then set <code>CURRENT_TIMESTAMP </code></li>
<li> <code>onUpdateTimeStamp()</code> : ON UPDATE CURRENT_TIMESTAMP  </li>
<li> <code>foreign($column)</code> : make CONSTRAINT for foreign key  </li>
<li> <code>on($reference)</code> : $reference means table.column. check following example.
<pre>
<code>    
$column->integer('user_id')->unsigned();
$column->foreign('user_id')->on('demo_users.id'); </code>
</pre>

</li>
</ol>


# 2. Simple Side Menu Declaration 
 <div id="SimpleSideMenuDeclaration"></div>

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
  <blockquote>In <code>DemoController@main</code>: <code>DemoController</code> is controller name
                        located at <code> app/controller/sidenav/ </code> and <code>main</code> is method name of
                        DemoController
 </blockquote>
  <b>Optional index:</b> position (default is 500), removeFirstSubmenu ( for delete first submenu, default false) <br>
</li>
<li>Third: closer function for registering submenu under main menu</li>
 </ol>
 <p class="mt-4"><b>The <code>sub method </code> has two parameters.</b></p>
 <ol>
 <li>One : menu slug . (Required)</li>
 <li>Two : menu options . Its type must be an array. <br>
  <b>Mandatory index:</b> title (Menu Title), as ( controller and method must be with
  <code>@</code> sign) <br>
  <blockquote>In <code>DemoController@main</code>: <code>DemoController</code> is controller name
                        located at <code> app/controller/sidenav/ </code> and <code>sub</code> is method name of
                        DemoController
 </blockquote>

 </li>
 </ol>
            
            
  
 # 3. Easy Rest API Route Declaration
 <div id="EasyRestAPIRouteDeclaration"></div>
 
<p>Create WP rest route in easy way.     </p>
<p> <b> Rest Route declaration file : routes/route.php </b>
 <br> <b> Rest Route Controller must declare inside : app/controller/api/ </b></p>
 <p><b>API Namespace:</b> Namespace maintain by <code>api_namespace</code> of config.php. It's located in <code>app/config/config.php</code>
            </p>
<p class="mt-3"><b>Sample Structure</b></p>
<pre><code>
$route->get('dashboard/{id?}', 'DemoController@dashboard');
$route->post('add-note', 'DemoController@addNote'); 
$route->post('update-note', 'DemoController@addNote', true); 
</code>
</pre>
<span><code>DemoController</code> is controller name and <code>dashboard</code> is method name , located in <code>app/controller/api/</code> directory</span>
<p class="mt-2"><b> PluginMaster has two methods: GET, POST   </b>  </p>
<p>Both Route has 3 parts/parameters</p>
<ul>
  <li> <b>First Parameter</b>: Route Name 
<ol>
 <li>Dynamic Parameter : <code>{parameter_name}</code></li>
<li>Dynamic Optional Parameter : <code>{parameter_name?} </code></li>
<li> Access Dynamic Param in Controller's method : set parameter like : <code>function dashboard($variable)</code> then <code>$variable['param_name'] </code></li>
</ol>
    
</li>
 <li><b>Second Parameter</b>:  Conteoller and Method Name ( with @ sign) </li> 
 <li><b>Third Parameter </b>: CSRF protection (Optional).Default value false. If you set true, can not access this route without <a href="#wpNonce">WP Nonce Token </a>. You must pass token in header with <code>X-WP-Nonce: token</code>  </li>
 
 </ul>
 
 
 # 4. DB Query Builder
 <div id="QueryBuilder"></div>
 <p>PluginMaster's database query builder provides a convenient, fluent interface to run
                database queries. It can be used to perform most database operations in your application. </p>
 <b>Namespace: <code>PluginMaster\DB\DB;</code></b><br> 
 
<br>
<b>DB Functions </b>
<ol>
<li>   Retrieving A Single Row<br><code>  DB::table('users')->first();</code></li>
<li>  Retrieving A multiple Row <br><code>  DB::table('users')->get();</code></li>
</ol>

 <ol>
 <li><code>where($column, $value )</code> :
 

 <pre class="mt-2"><code>DB::table('users')
     ->where('id', 1)
     ->get()</code></pre>

  <pre class="mt-2"><code>DB::table('users')
     ->where(function($query){
       $query->where('id', 1);
       $query->orWhere('name', "name");
     })
     ->get()</code></pre>

 </li>
  <li><code>orWhere($column, $value)</code> :
 <pre class="mt-2"><code>DB::table('users')
     ->where('id', 1)
     ->orWhere('name', "name")
     ->get()</code></pre>

 <pre class="mt-2"><code>DB::table('users')
     ->where('id', 1)
     ->orWhere(function($query){
         $query->where('field', 'value);
         $query->where('field', 'value);
         })
     ->first()</code></pre>

 </li>
 <li><code>whereRaw($query)</code> :
 <pre class="mt-2"><code>DB::table('users')
     ->whereRaw('id = 1')
     ->first()</code></pre>
    </li>

  <li><code>orWhereRaw($query)</code> :
  <pre class="mt-2"><code>DB::table('users')
     ->whereRaw('id = 1')
     ->orWhereRaw('id = 1')
     ->first()</code></pre>
 </li>


 <li><code>orderBy($columns, $direction)</code> :
 <pre class="mt-2"><code>DB::table('users')
     ->orderBy('id', 'desc')</code></pre>
                    <pre class="mt-2"><code>DB::table('users')
     ->orderBy('id,name', 'desc')</code></pre>
 </li>

   <li><code>groupBy($columns)</code> :
 <pre class="mt-2"><code>DB::table('users')
     ->groupBy('id')</code></pre>
                    <pre class="mt-2"><code>DB::table('users')
     ->groupBy('id,name')</code></pre>
 </li>


  <li><code>limit($number)</code> :
 <pre class="mt-2"><code>DB::table('users')
     ->where('id', 1)
     ->limit(number)->get()</code></pre>
  </li>

 <li><code>offset($number)</code> :
 <pre class="mt-2"><code>DB::table('users')
     ->where('id', 1)
     ->limit(number)->offset(number)->get()</code></pre>
 </li>

<li><code>select($fields)</code> :
<pre class="mt-2"><code>DB::table('users')
     ->select('id,name')
        ->get()</code></pre>
                </li>
                <li><code>insert($data)</code> :
                    <pre class="mt-2"><code>DB::table('users')
     ->insert(['name' => "demo"])</code></pre>
 </li>
<li><code>update($data,$where)</code> :
<pre class="mt-2"><code>DB::table('users')
     ->where('id', 1)
     ->update(['name' => "demo"])</code></pre>
</li>
<li><code>delete($where)</code> :
<pre class="mt-2"><code>DB::table('users')
     ->where('id', 1)
     ->delete()</code></pre>
</li>

<li><code>join($table, $first, $operator = null, $second = null) (INNER JOIN)</code>:
<pre class="mt-2"><code>DB::table('demo_notes as n')
        ->join('demo_users as u', 'u.id', '=', 'n.user_id')
        ->first()
</code></pre>
<pre class="mt-2"><code>DB::table('demo_notes as n')
        ->join('demo_users as u', function($query){
          $query->on( 'u.id', '=', 'n.user_id')
          $query->orOn( 'u.id', '=', 'n.user_id')
        })
        ->first()
</code></pre>

 <pre class="mt-2"><code>DB::table('demo_notes as n')
        ->join('demo_users as u', function($query) use($request){
          $query->on( 'u.id', '=', 'n.user_id')
          $query->onWhere( 'u.id', '=', $request->id)
        })
        ->first()
</code></pre>


 <blockquote>Note: Must use table alias for using join or leftJoin.</blockquote>
</li>
<li>
<code>leftJoin($table, $first, $operator = null, $second = null) (LEFT JOIN)</code>: <b> Same as
                        join()</b>
</li>

 <li><code>transaction()</code>:
<pre class="mt-2"><code>DB::startTransaction(function(){
    DB::table('demo_notes')
      ->insert([
         "note" => "Hello",
       ]);
})</code></pre>

<pre class="mt-2"><code>DB::startTransaction(function(DB $query){
    $query->table('demo_notes')
      ->insert([
         "note" => "Hello",
       ]);
})</code></pre>

 </li>
 </ol>



# 5. Simple Enqueue Declaration 
<div id="SimpleEnqueueDeclaration"></div>

 <p> Easy way to add css and js file to application</p>
<b> Enqueue Declaration file : enqueue/enqueue.php </b><br>
<b>Plugin Deactivation Script Declaration : enqueue/deactiveAction.php </b>
<p class="mt-3"><b>Functions</b></p>
<ol>
<li><code>  headerScript($path) :  </code>  : <br>
    <code>$enqueue->headerScript('assets/js/index.js');</code> </li>
<li><code>  headerScriptCdn($path) :  </code> : <br> <code>$enqueue->headerScriptCdn('http://alemran.me/js/index.js');</code> </li>
<li><code>  footerScript($path) :  </code>: <br> <code>$enqueue->footerScript('assets/js/index.js');</code> </li>
<li><code>  footerScriptCdn($path) :  </code> :<br> <code>$enqueue->footerScriptCdn('http://alemran.me/js/index.js');</code> </li>
<li><code>  style($path) :  </code> :<br> <code>$enqueue->style('assets/css/style.css');</code> </li>
<li><code>  styleCdn($path) :  </code>:<br> <code>$enqueue->style('assets/js/index.css');</code> </li>
<li id="wpNonce"> <code> csrfToken($handler, $objectName):  </code> :<br>

<pre>
<code>
$enqueue->footerScript('assets/js/index.js','DemoScriptIndex');
$enqueue->csrfToken('DemoScriptIndex','corsData');
</code>
</pre>
<p><code>DemoScriptIndex</code> is Handler and <code>corsData</code> is object name. You can access   api  ROOT url and token  corsData object. </p>
 <blockquote><b>Note:</b> CSRF token must define under a js file's Handler.</blockquote>
</li>

<li><code> $enqueue->hotScript('file_name.js') </code> for Webpack (DevServer) hot mode with Vue js (main url will be <code>  http://localhost:8080/file_name.js</code>)
 </li>
</ol>


# 6. Easy Shortcode Handler
 <div id="ShortCode"> </div> 
 <p>Create and manage shortcode in easy way</p>
 <b> Shortcode Declaration file : shortcode/shortcode.php </b><br>
 <b>Controller root directory for shortcode : app/controller/shortcode/ </b><br>
 <b>Example: </b>
 <pre> <code> $shortCode->add('pluginmaster', 'ShortCodeController@index' ) ; </code>  </pre>
 <p><code>pluginmaster</code> is the name of shortcode. <code>ShortCodeController</code> is controller and <code>index</code> is method name.</p>
 <p>Method Sample</p>
  <pre><code>
    public function index(){
          $data = DB::table('table_name')->get();
        return  view('shortcode', compact('data')) ;
    }
  </code></pre>
  
  

# 7. Request Handling System
<div id="RequestHandlingSystem" ></div>

<p> Easy way to access request data from native or AJAX request</p>
 <b> No need isset function to check. just call <code>$request->name</code> , it will return null if not
            set </b><br>
<p class="mt-3"><b>Example</b></p>
<pre> <code>
     use App\system\request\Request;
     $request = new Request();
     echo $request->name;
    </code>
    </pre>
<p><b>Access Header:</b> <code>$request->header(name)</code></p>
<p><b>Get All Data as Array:</b> <code>$request->all()</code></p>
<p><b>Check Request Method :</b> <code>if($request->isMethod('post')){}</code></p>


# 8. Validator 


<p> Validate data is easy in PluginMaster</p>
 <p class="mt-3"><b> Manually Validate ( not compatible for REST API) </b>:  </p>
  <pre>
  <code>
 use App\system\Validator;
  $validator = Validator::make($request, [
            'ID' => 'required|number|limit:10,11',
            'name' => 'required|wordLimit:10,20',
            'slug' => 'required|noSpecialChar',
        ]);

 if ($validator->fails()) {
     $errors =  $validator->errors();
 }

</code>
</pre>
<p>For checking validation fail: <code>$validator->fail();</code>.</p>
<p>For Validation errors: <code> $validator->errors() </code>.</p> 
<p>You can use <code>$validator->flashErrors();</code> for flashing errors as flash session and you can access  all flashed errors through <code>formErrors()</code> global function. Also you can access single field error  through <code>formError(field name).</code></p>
 
 <b>Display Errors in View file :</b>
<p>In controller</p>
<pre><code>
      use App\system\Validator;
      $validator = Validator::make($request, [
      'ID' => 'required|number|limit:10,11',
      'name' => 'required|wordLimit:10,20',
      'slug' => 'required|noSpecialChar',
      ]);
 </code> </pre>    
  <pre><code>    
    if ($validator->fails()) {
      $errors =  $validator->formErrors();
    }  
</code> </pre>

<p>In view file</p>
<pre><code>             
if ( count(formErrors()) ) :
      &lt;div class="alert alert-danger"&gt;
           &lt;ul&gt;
            &lt;php foreach (formErrors() as $key=>$value): ?&gt;
                   &lt;li&gt; &lt;php  echo $value; ?&gt;  &lt;/li&gt;
           &lt;php  endforeach; ?&gt;
         &lt;/ul&gt;
     &lt;/div&gt;
   &lt;php endif;  ?&gt;

  &lt;input type="text" name="email"&gt;
  &lt;p&gt; &lt;php  formError('email'); ?&gt;  &lt;/p&gt;
</code></pre>
<b>OR</b>
<p>You can pass errors to view file with compact</p>
<pre>
view('path to view', compact('errors'));
</pre>

<p class="mt-3"><b>Stopping On Validation Failure (Compatible for REST API) </b>: If validation fail then stop   other execution, just return validation errors.</p>
 <p>Example:</p>
 <pre><code>
          use App\system\request\Request;
                $request = new Request();
                $request->validate([
                  'name' => 'required',
                ]);

 </code> </pre>
 <p>Error will return as like following: </p>
<pre><code>
             [
                "message" => "Validation failed",
                "errors" => [
                 "name" => "name Field is required"
                 ]
              ]
</code></pre>

<b>Available Validation:</b>
<ol>
    <li>required</li>
    <li>mobile (start with zero and must be in 0-9)</li>
    <li>number</li>
    <li>floatNumber</li>
    <li>noNumber( accept all character without number)</li>
    <li>letter( accept only letter :A-Za-z))</li>
    <li>noSpecialChar</li>
    <li>limit: min, max</li>
    <li>wordLimit: min, max</li>
    <li>email</li>
</ol>


# 9. Build in Vue JS Configuration 
<div id="BuildinVueJSConfiguration"></div>

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
                    
 
 
 # 10. Global Functions
 
<div id="GlobalFunction"></div>

  <ol>
 <li><code>view()</code> : root of view file : <code>resources/view/</code>. you have to pass only file name withour extention  . Example: <code> view('home/index') </code> . 
  <br> <b> Also you can pass data to view with <code>compact </code>
     <code><pre>
       $title = "......";
       $data = [] ;
       return view('home/index', compact('title', 'data'))
     </pre></code>
  </li>
<li> <code> json($data, $code)</code> : for returning as json with status code</li>

<li> <code> config($key)</code> : for returning configuration data. you can set/ change  configuration data from : <code>add/config/config.php</code></li>
<li> <code> current_url()</code> : for current url</code></pre>
<li> <code> formErrors()</code> : for form validation errors as array</code></li>
<li> <code> formError($field_name)</code> : for single field  validation error </code></li>
<li> <code> session_flush($key, $value = null)</code> : for getting and setting <a href="#SessionHandler"> flush session</a> </code></li>
<li> <code> session($key, $value = null)</code> : for getting and setting <a href="#SessionHandler">  session </a> </code></li>

</ol>
  
 # 11.  Session Handler
 
 <div id="SessionHandler"></div>
<ol>
<li>Get OR Set Flush Session: <br>
<code>Session::flush(key)</code> for getting onetime Session and <code>Session::flush(key, value)</code>
                for setting onetime session.
<blockquote> Flush session unset after page loading completed</blockquote>
</li>
<li> Set Session:
<code>Session::flush(key, value)</code>
 </li>
<li> Get Session:
                <code>Session::get(key)</code>
</li>
<li> Forget Session:
                <code>Session::forget(key)</code>
</li>
</ol>

# License
<p>The MIT License (MIT)</p>

<p>Developed by : <a href="https://alemran.me">AL EMRAN</a></p>

# Support for this project
Assalamu Alikum ! You can donate for the project.

[![Beerpay](https://beerpay.io/emrancu/PluginMaster/badge.svg?style=beer-square)](https://beerpay.io/emrancu/PluginMaster)  [![Beerpay](https://beerpay.io/emrancu/PluginMaster/make-wish.svg?style=flat-square)](https://beerpay.io/emrancu/PluginMaster?focus=wish)
