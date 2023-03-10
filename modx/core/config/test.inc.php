<?php
ini_set('memory_limit', '2048M');
/**
 *  MODX Configuration file
 */
$database_type = 'mysql';
$database_server = '93.90.219.68';
$database_user = 'artelamp';
$database_password = 'e4G7VwlFI2XMwThO';
$database_connection_charset = 'utf8';
$dbase = 'artelamp';
$table_prefix = 'ara3_';
$database_dsn = 'mysql:host=93.90.219.68;port=3306;dbname=artelamp;charset=utf8';
$config_options = array(
    'media_server_images_source' => 'artelamp.ru'
);
$driver_options = array();

$lastInstallTime = 1606464940;

$site_id = 'modx5fc0b5ac807209.39343924';
$site_sessionname = 'SN5fc0b57f34a39';
$https_port = '443';
$uuid = 'f0ba02e5-2cd7-40b1-b78f-16207cb469ce';

if (!defined('MODX_CORE_PATH')) {
    $modx_core_path = '/var/www/artelamp_ru/data/www/artelamp.ru/public_html/core/';
    define('MODX_CORE_PATH', $modx_core_path);
}
if (!defined('MODX_PROCESSORS_PATH')) {
    $modx_processors_path = '/var/www/artelamp_ru/data/www/artelamp.ru/public_html/core/model/modx/processors/';
    define('MODX_PROCESSORS_PATH', $modx_processors_path);
}
if (!defined('MODX_CONNECTORS_PATH')) {
    $modx_connectors_path = '/var/www/artelamp_ru/data/www/artelamp.ru/public_html/connectors/';
    $modx_connectors_url = '/connectors/';
    define('MODX_CONNECTORS_PATH', $modx_connectors_path);
    define('MODX_CONNECTORS_URL', $modx_connectors_url);
}
if (!defined('MODX_MANAGER_PATH')) {
    $modx_manager_path = '/var/www/artelamp_ru/data/www/artelamp.ru/public_html/manager/';
    $modx_manager_url = '/manager/';
    define('MODX_MANAGER_PATH', $modx_manager_path);
    define('MODX_MANAGER_URL', $modx_manager_url);
}
if (!defined('MODX_BASE_PATH')) {
    $modx_base_path = '/var/www/artelamp_ru/data/www/artelamp.ru/public_html/';
    $modx_base_url = '/';
    define('MODX_BASE_PATH', $modx_base_path);
    define('MODX_BASE_URL', $modx_base_url);
}
if (defined('PHP_SAPI') && (PHP_SAPI == "cli" || PHP_SAPI == "embed")) {
    $isSecureRequest = false;
} else {
    $isSecureRequest = ((isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') || $_SERVER['SERVER_PORT'] == $https_port);
}
if (!defined('MODX_URL_SCHEME')) {
    $url_scheme = $isSecureRequest ? 'https://' : 'http://';
    define('MODX_URL_SCHEME', $url_scheme);
}
if (!defined('MODX_HTTP_HOST')) {
    if (defined('PHP_SAPI') && (PHP_SAPI == "cli" || PHP_SAPI == "embed")) {
        $http_host = 'artelamp.ru';
        define('MODX_HTTP_HOST', $http_host);
    } else {
        $http_host = array_key_exists('HTTP_HOST', $_SERVER) ? htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES) : 'artelamp.ru';
        if ($_SERVER['SERVER_PORT'] != 80) {
            $http_host = str_replace(':' . $_SERVER['SERVER_PORT'], '', $http_host); // remove port from HTTP_HOST
        }
        $http_host .= ($_SERVER['SERVER_PORT'] == 80 || $isSecureRequest) ? '' : ':' . $_SERVER['SERVER_PORT'];
        define('MODX_HTTP_HOST', $http_host);
    }
}
if (!defined('MODX_SITE_URL')) {
    $site_url = $url_scheme . $http_host . MODX_BASE_URL;
    define('MODX_SITE_URL', $site_url);
}
if (!defined('MODX_ASSETS_PATH')) {
    $modx_assets_path = '/var/www/artelamp_ru/data/www/artelamp.ru/public_html/assets/';
    $modx_assets_url = '/assets/';
    define('MODX_ASSETS_PATH', $modx_assets_path);
    define('MODX_ASSETS_URL', $modx_assets_url);
}
if (!defined('MODX_LOG_LEVEL_FATAL')) {
    define('MODX_LOG_LEVEL_FATAL', 0);
    define('MODX_LOG_LEVEL_ERROR', 1);
    define('MODX_LOG_LEVEL_WARN', 2);
    define('MODX_LOG_LEVEL_INFO', 3);
    define('MODX_LOG_LEVEL_DEBUG', 4);
}
