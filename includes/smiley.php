
<div id="chatSmiley">
    <?
    
    $url=__SKIN_PATH.'/css/';
    loadModel('listSmiley');
    $smiley=new smiley();
   $arraySymbol = $smiley->arraySymbol();
   $arraypath=$smiley->arrayPath();
    for ($i=0;$i<count($arraySymbol);$i++)
    {
        $symbol=$arraySymbol[$i];
        $filename=$arraypath[$i];
     ?>
       <img symbol="<?=$symbol?>" alt="<?=$filename?>" src="<?=$url?>images/smiley/<?=$filename?>.gif" class="smileychat">    
      <?
    }
    ?>
</div>