<?php


function showStatus($status)
{
    switch ($status) {
        case 'active': return 'đã kích hoạt';break;
        case 'deactive': return 'chưa kích hoạt';break;
        case 'contribute': return 'Đang xây dựng';break;
        default:
            return 'không rõ';
    }
}

function getsubstring($parentstring,$lenght)
{  if ($lenght>=strlen($parentstring)) return $parentstring;
    $next=$lenght;
  while (($parentstring[$next]!=' ') && ($next<strlen($parentstring)))
    $next++;
  if (($next-$lenght)>20) return substr($parentstring,0,$lenght+20)."....";
  if ($next==strlen($parentstring))
    return $parentstring;
    return substr($parentstring,0,$next)."...";
}



function splitPage($cPage,$nPage,$link,$ajax)
{  $addlink="";
    if ($ajax)
        $addlink = " onclick='return false;'";
    
    if ($nPage ==1)
        return;
    echo '<div class="pagesplit">';
    for ($i=1;$i<=$nPage;$i++)
    {
        if ($i == $cPage)
            echo "<span class='current'>$i</span>";
            else
            echo "<a href='$link/$i' class='page' $addlink >$i</a>";
    }
    echo '</div>';
	 
}

 function num_page($number_record,$rowperpage)
  {
    if($number_record%$rowperpage==0)
    {
      $n_page=$number_record/$rowperpage;
      return $n_page;
    }
    else
    {
      $n_page=($number_record-($number_record%$rowperpage))/$rowperpage+1;
      return $n_page;
    }
  }
  
  function replacesubstring($mother,$find,$replace)
{    $location=1;
  $mother=" ".$mother;
 while ($pos=strpos($mother,$find,$location))
 {
   
    $mother=substr_replace(  $mother  ,$replace  , $pos,strlen($find) );
    $location=$pos+strlen($replace);
 }
 return $mother;
}
  
function buildIndex($id)
{
    $id ="$id";
    $length = strlen($id);
    if ($length <3)
    {  $expection_num =3 - $length;
        return 'MS'.str_repeat('0', $expection_num).$id;
    }
    else
    {
        return 'MS'.$id;
    }
    
}
