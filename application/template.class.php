<?php

Class Template {
    /*
     * @the registry
     * @access private
     */

    private $registry;

    /*
     * @Variables array
     * @access private
     */
    private $vars = array();

    /**
     *
     * @constructor
     *
     * @access public
     *
     * @return void
     *
     */
    function __construct($registry) {
        $this->registry = $registry;
    }

    /**
     *
     * @set undefined vars
     *
     * @param string $index
     *
     * @param mixed $value
     *
     * @return void
     *
     */
    public function __set($index, $value) {
        $this->vars[$index] = $value;
    }

    public function __get($index) {
        if (isset($this->vars[$index]))
            return $this->vars[$index];
        else
            return null;
    }

    function show($name, $module= __MODULE_NAME) {

        $arrayview = explode('_', $name);
        $path =  __SITE_PATH.'/modules/'.$module.'/views/'. $arrayview[0] . '/' . $arrayview[1] . '.php';

        if (file_exists($path) == false) {
            throw new Exception('Template not found in ' . $path);
            return false;
        }

        // Load variables
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }

        include ($path);
    }
    
    function showLayout($controllerName, $actionName) {
     global  $registry;
     include __MODULE_PATH . "/configs/listLayout.php";
        $registry->listLayout = new listLayout($registry);

        if (isset($registry->layout_name))
            $layoutName = $this->registry->layout_name;
        else
            $layoutName = $registry->listLayout->__get($controllerName . '_' . $actionName);

        include(__SITE_PATH_LAYOUT . '/' . $layoutName);
    }

    function addScript($script_path)
    {
        global  $registry;
         if (isset($registry->js) && is_array($registry->js)){
             $js = $registry->js;
         }
         else
         {
             $js =array();
         }
         array_push($js, $script_path);
         $registry->js = $js;
    }
}
