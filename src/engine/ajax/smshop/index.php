<?php

if (file_exists(__DIR__ . '/' . $_REQUEST['mod'] . '.php')) {


    @error_reporting(E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);
    @ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);
    @ini_set('display_errors', true);
    @ini_set('html_errors', false);

    define('DATALIFEENGINE', true);
    define('ROOT_DIR', substr(dirname(__FILE__), 0, -18));
    define('ENGINE_DIR', ROOT_DIR . '/engine');

    include ENGINE_DIR . '/data/config.php';

    date_default_timezone_set($config['date_adjust']);

    require_once ENGINE_DIR . '/classes/mysql.php';
    require_once ENGINE_DIR . '/data/dbconfig.php';
    require_once ENGINE_DIR . '/modules/functions.php';
    require_once ENGINE_DIR . '/modules/sitelogin.php';

    require_once ENGINE_DIR . '/classes/smshop/helpers.class.php';
    require_once ROOT_DIR . '/engine/classes/smshop/include.php';

    dle_session();
    $req = file_get_contents('php://input');
    if (!empty($req))
        $req = json_decode($req, TRUE);
    require_once(__DIR__ . '/' . $_REQUEST['mod'] . '.php');

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }

    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($Res);

} else
    exit('METHOD NO FOUND ' . $_SERVER['DOCUMENT_ROOT'] . '/engine/ajax/rocketme/' . $_REQUEST['mod'] . '.php');


  
