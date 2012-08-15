<?php

/* * * include the controller class ** */
include __APPLICATION_PATH . 'controller_base.class.php';

include __APPLICATION_PATH . 'db.class.php';

/* * * include the registry class ** */
include __APPLICATION_PATH . 'registry.class.php';

/* * * include the router class ** */
include __APPLICATION_PATH . 'router.class.php';

/* * * include the template class ** */
include __APPLICATION_PATH . 'template.class.php';

include __APPLICATION_PATH . 'common.php';

include __SITE_PATH . '/includes/mail/class.phpmailer.php';

date_default_timezone_set("Asia/Bangkok");

/* * * auto load model classes ** */

function loadModel($class_name, $module_name= null) {
    global $registry;
    if ($module_name == null)
    {
        $module_name = $registry->default_module;
    }
    
    $filename = strtolower($class_name) . '.class.php';
    $file = __SITE_PATH . '/modules/' . $module_name . '/models/' . $filename;
    
    if (file_exists($file))
    require_once ($file);
    else
        die("$file not found");
}

/* * * a new registry object ** */
$registry = new registry;


/* * * create the database registry object ** */

// $registry->db = db::getInstance();
function loadClass($className) {

    $file = __SITE_PATH . '/includes/' . $className . '.php';
   
    if (is_readable($file) == false)
        die("<h1> Error: not found class </h1>");
    include_once ($file);
}

function urlControllerAction($controller, $action, $module=__MODULE_NAME, $language = __REQUEST_LANG) {
    global $registry;
    if ($module == "" || $module == null || $module == $registry->default_module)
        $module_add = "";
    else
        $module_add = $module . "/";
    if (!in_array($language, $registry->listlang)) {
        die("Language not found");
    }

    if ($language == $registry->default_language)
        $language_add = '';
    else
        $language_add = $language . '/';

    if ($controller =='index' && $action=='index')
      return __SERVERNAME . '/' . $language_add . $module_add ;
    if ($action == "" || $action == "index")
        return __SERVERNAME . '/' . $language_add . $module_add . $controller;
    return __SERVERNAME . '/' . $language_add . $module_add . $controller . '/' . $action;
}

function linkControllerAction($controller, $action, $title) {
    $url = urlControllerAction($controller, $action);
    return '<a href="' . $url . '"> ' . $title . ' </a>';
}

function SetUserCookie($name, $value, $expiredate) {
    setcookie($name, $value, $expiredate);
}

function setTitle($title) {
    global $registry;
    $registry->site_title =$title;
}

function check($value) {
    if (isset($value) && $value != null)
        return true;
    return false;
}

function translator($name, $section ='index') {
    global $registry;
    $lanuage_file = __INI_LANGUAGE . "/" . $section . '.ini';

    if (!file_exists($lanuage_file))
        die("file $lanuage_file not found");

    $language_dict = NULL;
    $data = NULL;

    if (!(isset($registry->language_dict))) {

        $language_dict =  (object)null;
        $language_dict->$section = parse_ini_file($lanuage_file, false);
        $registry->language_dict = $language_dict;
    } else {
        $language_dict = $registry->language_dict;
        if (!isset($language_dict->$section)) {
            $language_dict->$section = parse_ini_file($lanuage_file, false);
            $registry->language_dict->$section = $language_dict->$section;
        }
    }

    $data =$language_dict->$section;
    if (!isset($data[$name]))
        return ' ' . $name;
    return  $data[$name];
}

function script_files(){
    global  $registry;
    if (isset($registry->js) && is_array($registry->js)){
        foreach ($registry->js as $item)
        {
            echo sprintf(' <script type="text/javascript" src="%s"></script>',$item);
        }
    }
}

      
     function showSubCat($parent_id,$list_cat,$index,$curr_categoryid)
    {
       
        for ($i = $index ; $i < count($list_cat); $i++) {
            $item = $list_cat[$i];
            if ($item->parent_id == $parent_id)
            { 
              
                 $selected = ($item->id == $curr_categoryid) ? "selected" : "";
           
                echo "<option value='{$item->id}' {$selected}>----{$item->name} </option>";
            }
        }   
    }
