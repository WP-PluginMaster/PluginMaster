<?php

namespace App\system\enqueue;


use App\system\core\Settings;
use PluginMaster\Enqueue\Enqueue;

class EnqueueRegister extends Enqueue
{

    public function __construct()
    {
        parent::__construct();
        $this->plugin = Settings::$plugin_root;
        $this->pluginRoot = Settings::$plugin_dir;

    }

    /**
     *
     */
    public function initAsset()
    {
        add_action('admin_enqueue_scripts', array($this, 'init'));
    }

    /**
     * @param $hook
     */
    public function init($hook)
    {
        if ($hook == 'plugins.php') {
            $this->deActiveAction();
        } else {

            $currentNav = urldecode(explode('page=', $_SERVER['REQUEST_URI'])[1]);

            if ('toplevel_page_' . Settings::$main_menu === $hook || strtolower(Settings::$main_menu) . '_page_' . $currentNav == $hook) {

                $enqueue = $this;
                require_once Settings::$plugin_path . '/enqueue/enqueue.php';
            }

        }


    }


    /**
     *
     */
    private function deActiveAction()
    {
        add_filter('plugin_action_links_' . $this->plugin, [$this, 'deActiveActionData']);
    }


}
