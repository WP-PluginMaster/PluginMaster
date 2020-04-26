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
        if (is_admin()) {
            add_action('admin_enqueue_scripts', array($this, 'init_admin_enqueue'));
        } else {
            add_action('wp_enqueue_scripts', array($this, 'init_front_enqueue'));
        }
    }

    /**
     * @param $hook
     */
    public function init_admin_enqueue($hook)
    {
        if ($hook == 'plugins.php') {
            $this->deActiveAction();
        } else {
            $currentURI = explode('page=', $_SERVER['REQUEST_URI']);
            $currentNav = isset($currentURI[1]) ? urldecode($currentURI[1]) : '';

            if ('toplevel_page_' . Settings::$main_menu === $hook || strtolower(Settings::$main_menu) . '_page_' . $currentNav == $hook) {

                $enqueue = $this;
                require_once Settings::$plugin_path . '/enqueue/adminEnqueue.php';
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

    /**
     * @param $hook
     */
    public function init_front_enqueue($hook)
    {
        $enqueue = $this;
        require_once Settings::$plugin_path . '/enqueue/frontEnqueue.php';

    }


    /**
     * @param $links
     * @return mixed
     */
    public function deActiveActionData($links)
    {
        $data = file_get_contents(Settings::$plugin_path . '/enqueue/deactiveAction.php');
        array_push($links, $data);
        return $links;
    }

}
