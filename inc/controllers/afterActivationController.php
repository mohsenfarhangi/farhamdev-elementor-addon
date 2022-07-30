<?php

namespace SWPS\Inc;

class afterActivationController
{

    public static function callBack()
    {
        $obj = new afterActivationController();
//        $obj->dbChats();
    }

//    public function dbChats()
//    {
//        $table_name = $this->createTableName('fdup_chats');
//        $sql        = "CREATE TABLE IF NOT EXISTS $table_name(
//		id int(11) NOT NULL AUTO_INCREMENT,
//		user_id int(11) NOT NULL,
//		dr_id int(11) NOT NULL,
//		order_id int(11) NOT NULL,
//        status varchar(32) NOT NULL,
//		created_at varchar(64) NOT NULL,
//		PRIMARY KEY  (id)
//	    )";
//
//        $this->createTable($sql);
//    }


    public function createTableName($table_name): string
    {
        global $wpdb;
        return $wpdb->prefix . $table_name;
    }

    public function createTable($sql)
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        return dbDelta($sql . $charset_collate);
    }

}