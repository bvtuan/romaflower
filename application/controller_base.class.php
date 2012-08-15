<?php

Abstract Class baseController {

/*
 * @registry object
 */
protected $registry;

function __construct($registry) {
	$this->registry = $registry;
}

/**
 * @all controllers must contain an index method
 */
function indexAction(){
    
    $this->registry->router->render('error404','index');
}

public function set_no_layout(){
  $this->registry->display_layout = true;
 }
 
 public function set_layout($name){
  $this->registry->layout_name =$name;   
 }
 
 public function show($view_name)
 {
     $this->registry->template->show($view_name);
 }
 
 public function addScript($file){
     $this->registry->template->addScript($file);
 }
 
 public function isAjaxRequest(){
     return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ;
     
 }
 public function assignView($name,$value)
 {
     $this->registry->template->$name= $value;
 }
 public function getArgs(){
     return   $this->registry->router->getarg();
 }
 public function render($controller, $action)
 {
      $this->registry->router->render($controller,$action);
 }
 
 public function setTitle($title)
 {
     $this->registry->site_title = translator('site_name').'|'. $title;
 }
}



?>
