<?php

namespace App\system\enqueue;


use App\system\core\base\Enqueue;

class EnqueueRegister implements Enqueue
{

    public $plugin;
    public $pluginRoot;

    public function __construct()
    {
        $this->plugin = $GLOBALS['plugin_base'];
        $this->pluginRoot = plugin_dir_path($this->plugin);

    }

    public function initAsset()
    {
        add_action('admin_enqueue_scripts', array($this, 'init'));
    }

    public function init($hook)
    {
        global $mainMenu;
        $currentNav = urldecode(explode('page=', $_SERVER['REQUEST_URI'])[1]);

        if ('toplevel_page_' . $mainMenu == $hook || strtolower($mainMenu) . '_page_' . $currentNav == $hook) {
            enqueue_file($this);
        }

        if($hook == 'plugins.php'){
            $this->deActiveAction();
       }



    }


    /**
     * @param $handler
     * @param $objectName
     */
    public function csrfToken($handler, $objectName)
    {
        wp_localize_script($handler, $objectName, array(
            'root' => esc_url_raw(rest_url()),
            'security' => wp_create_nonce('wp_rest')
        ));
    }


    /**
     * @param $path
     * @param string $id
     */
    public function footerScriptCdn($path, $id = '')
    {
        $handler = $id ? $id : uniqid();
        wp_enqueue_script($handler, $path, array(), '1.0.0', true);
    }


    /**
     * @param $path
     * @param string $id
     */
    public function footerScript($path, $id = '')
    {
        $handler = $id ? $id : uniqid();
        $path = plugins_url($this->pluginRoot) . $path;
        wp_enqueue_script($handler, $path, array(), '1.0.0'  , true);
    }

    /**
     * @param $fileName
     * @param int $port
     */
    public function hotScript($fileName, $port = 8080)
    {
        $handler = uniqid();
        $path = 'http://localhost:' . $port . '/assets/' . $fileName;
        wp_enqueue_script($handler, $path, array(), '1.0.0', true);
    }


    /**
     * @param $path
     * @param string $id
     */
    public function headerScriptCdn($path, $id = '')
    {
        $handler = $id ? $id : uniqid();
        wp_enqueue_script($handler, $path, array(), '1.0.0', false);
    }


    /**
     * @param $path
     * @param string $id
     */
    public function headerScript($path, $id = '')
    {
        $handler = $id ? $id : uniqid();
        $path = plugins_url($this->pluginRoot) . $path;
        wp_enqueue_script($handler, $path, array(), '1.0.0', false);
    }


    /**
     * @param $path
     */
    public function style($path)
    {
        $path = plugins_url($this->pluginRoot) . $path;
        wp_enqueue_style(uniqid(), $path, array(), '1.0.0', 'all');
    }


    /**
     * @param $path
     */
    public function styleCdn($path)
    {
        wp_enqueue_style(uniqid(), $path, array(), '1.0.0', 'all');
    }

    public function deActiveAction()
    {

        add_filter('plugin_action_links_' . $this->plugin, [$this, 'deActiveActionData']);

    }


    public function deActiveActionData($links)
    {
        $data = file_get_contents(plugin_dir_path(__FILE__) . '../../../enqueue/deactiveAction.php');
        array_push($links, $data);
        return $links;
    }


}
