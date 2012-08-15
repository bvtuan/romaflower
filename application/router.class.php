<?php

class router {
    /*
     * @the registry
    */

    private $registry;

    /*
     * @the controller path
    */
    private $args = array();
    public $file;
    public $controller;
    public $action;

    function __construct($registry) {
        $this->registry = $registry;
    }

    public function getarg() {
        return $this->args;
    }

    public function setarg($array) {
        $this->args = $array;
    }

    /**
     *
     * @set controller directory path
     *
     * @param string $path
     *
     * @return void
     *
     */

    /**
     *
     * @load the controller
     *
     * @access public
     *
     * @return void
     *
     */
    public function checkControllerAction() {
        return is_readable($this->file);
    }

    private function addPlugin($array_list, $module_name) {
        if ($array_list == null || count($array_list) == 0)
            return;
        $array_list =$array_list[$module_name];
        foreach ($array_list as $name) {
            $file_name='plugins/' . $name . '.php';
            
            if (!file_exists(__APPLICATION_PATH."/". $file_name))
            {
                die("Plugin $name not found");
            }
            
            include_once 'plugins/' . $name . '.php';
            $object = new $name($this->registry);
            if (is_callable(array($object, 'start'))) {
                $object->start();
            } else {
                die($name . " not found");
            }
        }
    }

    private function loadPlugin() {
        
        include_once 'plugin.php';
        $array_list = array("default" => array(),
            "admin" => array("checkAdminLogin"));
        $this->addPlugin($array_list, __MODULE_NAME);
    }

    public function loader() {
        /*         * * if the file is not there diaf ** */
        $this->loadPlugin();

        if (is_readable($this->file) == false) {
            $this->file = $this->path . '/error404Controller.php';
            $this->controller = 'error404';
        }

        /*         * * include the controller ** */
        include_once $this->file;

        /*         * * a new controller class instance ** */
        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);

        /*         * * check if the action is callable ** */
        if (is_callable(array($controller, $this->action)) == false) {
            $action = 'indexAction';
        } else {

            $action = $this->action;
        }
        /*         * * run the action ** */
        $controllerName = $this->controller;
        $actionName = $this->action;
        ob_start();
        $controller->$action($this->args);

        $this->registry->content = ob_get_contents();
        ob_end_clean();
    }

    /**
     *
     * @get the controller
     *
     * @access private
     *
     * @return void
     *
     */
    private function setAllConstant($module) {
        define("__MODULE_NAME", $module);
        define("__SKIN_PATH", __SERVERNAME . "/skins/" . $module);
        define("__MODULE_PATH", __SITE_PATH . "/modules/" . $module);
        define('__SITE_PATH_LAYOUT', __SITE_PATH . '/modules/' . $module . '/layouts');
        define("__VIEW_PATH", __SITE_PATH . '/modules/' . $module . '/views');
        define("__CONTROLLER_PATH", __SITE_PATH . '/modules/' . $module . '/controllers');
        define('__INI_LANGUAGE', __SITE_PATH . '/modules/' . $module . '/languages/' . __REQUEST_LANG);
    }


    public function getController() {

        /*         * * get the route from the url ** */
        $list_module = $this->registry->modules;
        $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];
        $this->args = explode('/', $route);
        if ($this->args != null && count($this->args) != 0) {
            $leng = count($this->args);
            for ($i = 0; $i < $leng; $i++) {
                $this->args[$i] = mysql_real_escape_string($this->args[$i]);
            }
        }


        if (in_array($this->args[0], $this->registry->listlang)) {
            define('__REQUEST_LANG', strtolower($this->args[0]));
            array_shift($this->args);
        } else {
            define('__REQUEST_LANG', $this->registry->default_language);
        }

        if (empty($this->args)) {
            $route = 'index';
            $this->setAllConstant($this->registry->default_module);
        } else {
            /*             * * get the parts of the route ** */
            if (in_array($this->args[0], $list_module)) {
                $this->setAllConstant($this->args[0]);
                array_shift($this->args);
            } else {
                $this->setAllConstant($this->registry->default_module);
            }

            if (isset($this->args[0])) {
                $this->controller = $this->args[0];
                array_shift($this->args);
            }


            if (isset($this->args[0])) {
                $this->action = $this->args[0] . 'Action';
            }
        }

        if (empty($this->controller)) {
            $this->controller = 'index';
        }

        /*         * * Get action ** */
        if (empty($this->action)) {
            $this->action = 'indexAction';
        }


        /*         * * set the file path ** */
        $this->file = __CONTROLLER_PATH . '/' . $this->controller . 'Controller.php';
        if (is_readable($this->file) == false) {
            $this->file = __CONTROLLER_PATH . '/error404Controller.php';
            $this->controller = 'error404';
        }

        /*         * * include the controller ** */
        include_once $this->file;

        /*         * * a new controller class instance ** */
        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);

        /*         * * check if the action is callable ** */
        if (is_callable(array($controller, $this->action)) == false)
            $this->action = 'indexAction';


        /*         * * run the action ** */
    }

    public function render($_controller, $_action,$module = __MODULE_NAME) {
        $__file = __SITE_PATH . '/modules/' .$module.'/controllers/'. $_controller . 'Controller.php';
        /**
         * include the controller
         * * */
        require_once $__file;
        /*         * * a new controller class instance ** */
        $class = $_controller . 'Controller';
        $_action = $_action . 'Action';
        $controller = new $class($this->registry);

        /*         * * check if the action is callable ** */
        /*         * * run the action ** */
        $controller->$_action();
    }

    public function redirect($controller, $action, $module=__MODULE_NAME,$addParam ="") {
        $url = urlControllerAction($controller, $action, $module).$addParam;
        header('Location:' . $url);
    }

}

?>
