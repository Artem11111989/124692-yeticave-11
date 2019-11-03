<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once('functions.php');
require_once('data.php');
$page_content = include_template('main.php', ['category' => $category, 'lots' => $lots]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Главная']);
print($layout_content);
