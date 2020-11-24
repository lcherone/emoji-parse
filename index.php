<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

// connect
try {
    $pdo = new PDO(
        sprintf("mysql:host=%s;dbname=%s;charset=utf8mb4", 
            getenv('DB_HOSTNAME'), 
            getenv('DB_DATABASE')
        ), 
        getenv('DB_USERNAME'), 
        getenv('DB_PASSWORD'), 
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (\PDOException $e) {
    exit('Error: '.$e->getMessage().' - Code: '.(int)$e->getCode());
}

// create table
try {
    $pdo->exec("
        SET NAMES utf8;
        SET time_zone = '+00:00';
        SET foreign_key_checks = 0;
        SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

        SET NAMES utf8mb4;

        DROP TABLE IF EXISTS `emojis`;
        CREATE TABLE `emojis` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `subgroup` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `emoji` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `version` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `emoji_version` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
} catch (\PDOException $e) {
    exit('Error: '.$e->getMessage().' - Code: '.(int)$e->getCode());
}

// include parser
include 'parse.php';

// insert into db
$stmt = $pdo->prepare("
INSERT INTO emojis VALUES (
    NULL,
    :group, 
    :subgroup, 
    :name, 
    :status,
    :emoji, 
    :version, 
    :description, 
    :emoji_version
)");

$rows = 0;
$errors = 0;
foreach ($emoji as $a) {
    foreach ($a as $b) {
        foreach ($b as $row) {
            try {
                $stmt->execute([
                    'group' => $row['group'],
                    'subgroup' => $row['subgroup'],
                    'name' => $row['name'],
                    'status' => $row['status'],
                    'emoji' => $row['emoji'],
                    'version' => $row['version'],
                    'description' => $row['description'],
                    'emoji_version' => $version
                ]);
                $rows++;
            } catch (\PDOException $e) {
                $errors++;
            }
        }
    }
}

// mysql dump
$cmd = sprintf(
    "mysqldump --add-drop-table --user=%s --password=%s --host=%s %s > output/%s.sql",
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD'),    
    getenv('DB_HOSTNAME'), 
    getenv('DB_DATABASE'),
    $version
);

`$cmd`;

echo '
    Done, imported '.$rows.' emojis and '.$errors.' failed.<br>
    Database dump file is here <a href="./output/'.$version.'.sql" target="_blank">./output/'.$version.'.sql</a>
';