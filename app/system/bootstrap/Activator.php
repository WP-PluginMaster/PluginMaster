<?php

namespace App\system\bootstrap;

class Activator
{


    public function __construct()
    {

    }

    /**
     * @return void
     */
    public function activate()
    {
        $this->initMigration();
    }

    public function initMigration()
    {
        global $wpdb;
        $migrationDir = plugin_dir_path(__FILE__) . '../../../database/migrations';

        $charset = $wpdb->get_charset_collate();

        foreach (scandir($migrationDir) as $filename) {
            $path = $migrationDir . '/' . $filename;
            if (is_file($path)) {
                require $path;
                $sequence = explode('_', $filename)[0];
                $actualFIleName  = str_replace($sequence.'_', '', $filename);
                $classname = explode('.', $actualFIleName )[0];
                $schema = new $classname();
                $sql = $schema->up()->sql;
                $this->create($classname, $sql, $charset);
            }
        }
    }


    public function create($tableName, $sql, $charset_collate)
    {
        global $table_prefix, $wpdb;

        $table = $table_prefix . "$tableName";

        if ($wpdb->get_var("show tables like '$table'") != $table) {
            $finalSql = $sql . $charset_collate;
            $this->execute($finalSql);
        }
    }

    public function execute($sql)
    {
        require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }


}
