<?php

namespace App\system\enqueue;


use PluginMaster\Enqueue\Enqueue;

class EnqueueRegister extends Enqueue
{

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

            $enqueue = $this;
            require_once plugin_dir_path(__FILE__) . '../../../enqueue/enqueue.php';
        }

        if ($hook == 'plugins.php') {
            $this->deActiveAction();
        }

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
