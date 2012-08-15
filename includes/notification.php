<?php

function showNotification($title=null,$class='success')
{
    $list = array("deleted"=>"Đã xóa thành công","active"=>"Đã active thành công","deactive"=>"Đã deactive thành công");
    if ((isset($_GET['info']) && array_key_exists($_GET['info'], $list)) || ($title!= null) )
    {
     ?>
    <div class="notification <?php echo $class ?> png_bg">
        <a href="#" class="close"><img src="<?php echo __SKIN_PATH; ?>/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
        <div>
        <?php
        if ($title != null)
        echo $title;
        else
        echo $list[$_GET['info']]; 
        
        ?>
        </div>
    </div>
<?php
    }
}