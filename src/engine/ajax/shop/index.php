<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/engine/ajax/shop/' . $_REQUEST['mod'] . '.php')) {

    // @error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
    // @ini_set('display_errors', true);
    // @ini_set('html_errors', false);
    // @ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE);

    define('DATALIFEENGINE', true);
    define('ROOT_DIR', substr(dirname(__FILE__), 0, -17));
    define('ENGINE_DIR', ROOT_DIR . '/engine');

    include ENGINE_DIR . '/data/config.php';

    date_default_timezone_set($config['date_adjust']);

    require_once ENGINE_DIR . '/classes/mysql.php';
    require_once ENGINE_DIR . '/data/dbconfig.php';
    require_once ENGINE_DIR . '/modules/functions.php';
    require_once ENGINE_DIR . '/modules/sitelogin.php';

    include ROOT_DIR . '/language/' . $config['langs'] . '/website.lng';

    dle_session();


    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

// Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }

        exit(0);
    }

    $Res = [];
    require_once($_SERVER['DOCUMENT_ROOT'] . '/engine/ajax/shop/' . $_REQUEST['mod'] . '.php');

    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($Res);

} else {
    exit('METHOD NO FOUND');
}

  
