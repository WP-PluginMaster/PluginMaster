<?php

namespace App\system\bootstrap;

use App\system\core\Settings;

class DeActivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public function deactivate()
    {
        $this->deleteTable();
    }


    public function deleteTable()
    {
        global $wpdb, $table_prefix;
        $migrationDir = Settings::$plugin_path . '/database/migrations';

        foreach (array_reverse(scandir($migrationDir)) as $filename) {
            $path = $migrationDir . '/' . $filename;
            if (is_file($path)) {
                $sequence = explode('_', $filename)[0];
                $actualFIleName = str_replace($sequence . '_', '', $filename);
                $classname = explode('.', $actualFIleName)[0];
                $tableName = $table_prefix . $classname;

                $sql = "DROP TABLE $tableName";
                $wpdb->query($sql);
            }
        }
    }


}
