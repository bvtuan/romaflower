<?php

class listLayout {

 /*
 * @the vars array
 * @access private
 */
 private $vars = array();


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
protected $registry;

function __construct($registry) {
	$this->registry = $registry;
       $this->instance();
}
 
 public function __set($index, $value)
 {
	$this->vars[$index] = $value;
 }
 
 /**
 *
 * @get variables
 *
 * @param mixed $index
 *
 * @return mixed
 *
 */
 public function __get($index)
 {
    $split=explode('_', $index);
    $controller=$split[0];
   
    
    if (isset($this->vars[$index]) == false)
    {
         if (isset($this->vars[$controller])==true)
        {
         return $this->vars[$controller];
         
        }
       if($this->registry->router->checkControllerAction()==false)
            return "errorlayout.php";
        else
        return "layoutmain.php";
    }
    
    return $this->vars[$index];
 }
 public function instance(){
  
     
    $this->__set('error404','alone_action.php'); 
    
    $this->__set('index_indexAction','layoutmain.php');
    $this->__set('blog_index','alone_action.php');
    $this->__set('comment_replyAction','alone_action.php');
    $this->__set('comment_addAction','alone_action.php');
    $this->__set('p','alone_action.php');
    $this->__set('rss_indexAction','alone_action.php');
    $this->__set('comment_viewCommentInarticleAction','alone_action.php');
    
    $this->__set('member_deleteListAction','alone_action.php');
    $this->__set('member_listMemberAction','alone_action.php');
    $this->__set('member_updateAction','alone_action.php');
    $this->__set('member_saveUpdateAction','alone_action.php');
    $this->__set('member_loginAction','alone_action.php');
    
    
    $this->__set('articles_updateAction','alone_action.php');
    $this->__set('articles_saveupdateAction','alone_action.php');
    $this->__set('articles_addAction','adminLayout.php');
    $this->__set('articles_saveAction','alone_action.php');
    $this->__set('articles_listArticleAction','alone_action.php');
    $this->__set('articles_deleteAction','alone_action.php');
    $this->__set('articles_indexAction','articleLayout.php');
    
    $this->__set('category_listCategoryAction','alone_action.php');
    $this->__set('category_deleteListAction','alone_action.php');
    $this->__set('category_updateAction','alone_action.php');
    $this->__set('category_saveupdateAction','alone_action.php');
    
    $this->__set('contact_deleteListAction','alone_action.php');
    $this->__set('contact_listContactAction','alone_action.php');
    $this->__set('contact_replyAction','alone_action.php');
    $this->__set('contact_saveReplyAction','alone_action.php');
    
    
    $this->__set('admin_loginAction','adminLogin.php');
    $this->__set('admin','adminLayout.php');
    
 }
}

?>