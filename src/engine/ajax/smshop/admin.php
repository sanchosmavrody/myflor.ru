<?php

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

dle_session();

$Res = [];
if (!empty($member_id['user_group']) and $member_id['user_group'] == 1 or TRUE) {
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }

    require_once ENGINE_DIR . '/classes/smshop/helpers.class.php';
    require_once ROOT_DIR . '/engine/classes/smshop/include.php';

    $req = file_get_contents('php://input');
    if (!empty($req))
        $req = json_decode($req, TRUE);
    if (file_exists(ENGINE_DIR . '/ajax/smshop/admin/' . $_REQUEST['mod'] . '.php'))
        require_once(ENGINE_DIR . '/ajax/smshop/admin/' . $_REQUEST['mod'] . '.php');
    else
        require_once(ENGINE_DIR . '/ajax/smshop/admin/default.php');
}


header('Content-Type: application/json; charset=UTF-8');
echo json_encode($Res);