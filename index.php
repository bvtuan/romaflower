<?php
session_start();
ini_set('session.gc_maxlifetime', 30*60); // 30 phut

/*** error reporting on ***/
error_reporting(E_ALL);

/*** define the site path ***/
$site_path = realpath(dirname(__FILE__));

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$servername = "http://" . $host . $uri;
define('DS', '/');
define('__UNIT_CURRENCY', 5000);
define ('__SERVERNAME', $servername);
define ('__SITE_PATH', $site_path);

define ('__UPLOAD_URL', $servername.DS.'upload');
define ('__UPLOAD_PATH', $site_path.DS.'upload');
define ('__CACHE_TIME', 100);
define ('__ENABLE_CACHE',TRUE);

define ('__APPLICATION_PATH', __SITE_PATH. '/application/');
define ('__PREFIX_DATABASE', 'gov_');
define ('__SESSIONID' , session_id());
define ('__EMAILCONTACT' , 'nhannt@tekciz.com');

/*** include the init.php file ***/
include __APPLICATION_PATH.'/init.php';

$registry->modules=array("default","admin");
$registry->default_module="default";

$registry->listlang=array("en","vn");
$registry->default_language="en";

/*** load the router ***/
$registry->router = new router($registry);

/*** set the controller path ***/
$registry->router->getController();

/*** load up the template ***/
$registry->template = new template($registry);

$registry->router->loader();

if ($registry->__isset('display_layout') && $registry->display_layout ==1) {
    echo $registry->content;
} 
else {
    include __MODULE_PATH . "/configs/listLayout.php";
    $registry->listLayout = new listLayout($registry);

    if (isset($registry->layout_name))
        $layoutName = $registry->layout_name.'.php';
    else
        $layoutName = $registry->listLayout->__get($registry->router->controller . '_' . $registry->router->action);
    include(__SITE_PATH_LAYOUT . '/' . $layoutName);
}
