<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define paths
$baseDir = __DIR__; 
$dbDir = $baseDir . '/db'; 
$dbFile = $dbDir . '/recipe_db.db'; 


// Define a custom function for SQLite
function my_udf_md5($string) {
    return md5($string);
}

// Define the database connection class
class DBConnection extends SQLite3 {
    protected $db;

    function __construct() {
        global $dbFile;
        $this->open($dbFile);
        $this->createFunction('md5', 'my_udf_md5');
        $this->exec("PRAGMA foreign_keys = ON;");

        $this->exec("CREATE TABLE IF NOT EXISTS `admin_list` (
            `admin_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `fullname` TEXT NOT NULL,
            `username` TEXT NOT NULL,
            `password` TEXT NOT NULL,
            `type` INTEGER NOT NULL DEFAULT 1,
            `status` INTEGER NOT NULL DEFAULT 1,
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $this->exec("CREATE TABLE IF NOT EXISTS `category_list` (
            `category_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `name` TEXT NOT NULL,
            `description` TEXT NOT NULL
        )");

        $this->exec("CREATE TABLE IF NOT EXISTS `user_list` (
            `user_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `fullname` TEXT NOT NULL,
            `username` TEXT NOT NULL,
            `password` TEXT NOT NULL,
            `status` INTEGER NOT NULL DEFAULT 1,
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $this->exec("CREATE TABLE IF NOT EXISTS `recipe_list` (
            `recipe_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `category_id` INTEGER NOT NULL,
            `user_id` INTEGER NOT NULL,
            `title` TEXT NOT NULL,
            `description` TEXT NOT NULL,
            `ingredients` TEXT NOT NULL,
            `step` TEXT NOT NULL,
            `other_info` TEXT NOT NULL,
            `status` INTEGER NOT NULL,
            `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(`category_id`) REFERENCES `category_list`(`category_id`) ON DELETE CASCADE,
            FOREIGN KEY(`user_id`) REFERENCES `user_list`(`user_id`) ON DELETE CASCADE
        )");

        $this->exec("CREATE TABLE IF NOT EXISTS `comment_list` (
            `comment_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `recipe_id` INTEGER NOT NULL,
            `user_id` INTEGER NOT NULL,
            `message` TEXT NOT NULL,
            `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(`recipe_id`) REFERENCES `recipe_list`(`recipe_id`) ON DELETE CASCADE,
            FOREIGN KEY(`user_id`) REFERENCES `user_list`(`user_id`) ON DELETE CASCADE
        )");

        // Insert default admin and user if they do not exist
        $this->exec("INSERT OR IGNORE INTO `admin_list` VALUES (1, 'Administrator', 'admin', md5('admin123'), 1, 1, CURRENT_TIMESTAMP)");
        $this->exec("INSERT OR IGNORE INTO `user_list` VALUES (1, 'Cooking Companion Mgt', 'mgt', md5('mgt123'), 1, CURRENT_TIMESTAMP)");
    }

    function __destruct() {
        $this->close();
    }
}

// Create a new database connection
$conn = new DBConnection();
