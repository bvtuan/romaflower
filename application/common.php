<?php
function checkPost($postname) {
    if (isset($_POST[$postname]) && $_POST[$postname] != "")
        return true;
    return false;
}

function checkGet($getname) {
    if (isset($_GET[$getname]) && $_GET[$getname] != "")
        return true;
    return false;
}

function checkValidPage($totalPage,$currentPage) {
    global  $registry;

    if ($totalPage < $currentPage && $totalPage!=0) {
        $registry->router->render("error404","index");
        return false;
    }
    return true;
}

function checkRole($result,$permission_name) {
    if ($result == null || count($result)==0)
        return false;
    foreach ($result as $item) {
        if ($item->permission_name==$permission_name)
            return true;
    }
    return false;
}

function getRequest($requestname) {
    if (checkPost($requestname))
        return removeXSS($_POST[$requestname]);
    if (checkGet($requestname))
        return removeXSS($_GET[$requestname]);
    return "";
}

function validEmail($email) {
    return filter_var( $email, FILTER_VALIDATE_EMAIL );
}

function removeXSS($val) {
    $val = trim($val);
    $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
        $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
    }
    $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);
    $found = true;
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
                    $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
                    $pattern .= ')?';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
            if ($val_before == $val) {
                $found = false;
            }
        }
    }
    return $val;
}
/*
 * Nhannt
*/

function sendMail($subject,$content,$email) {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host     = "mail.tekciz.com";
    $mail->SMTPAuth = true;
    $mail->Username = "alert.mgov@tekciz.com";
    $mail->Password = "tekciz2011";
    $mail->From     = "alert.mgov@tekciz.com";
    $mail->FromName = "Cong Van Dien Tu Chinh Phu";
    $mail->AddAddress($email);
    $mail->WordWrap = 50;
    $mail->IsHTML(true);
    $mail->Subject  =  $subject;
    $mail->Body     =  $content;
    $mail->AltBody  =  $content;
    @$mail->Send();
}

function replaceUnicode($text, $plugchar=' ', $replace='-') {
    $characterHash = array (
            'a'	=>	array ('a', 'A', 'à', 'À', 'á', 'Á', 'â', 'Â', 'ã', 'Ã', 'ä', 'Ä', 'å', 'Å', 'ª', 'ą', 'Ą', 'а', 'А', 'ạ', 'Ạ', 'ả', 'Ả', 'Ầ', 'ầ', 'Ấ', 'ấ', 'Ậ', 'ậ', 'Ẩ', 'ẩ', 'Ẫ', 'ẫ', 'Ă', 'ă', 'Ắ', 'ắ', 'Ẵ', 'ẵ', 'Ặ', 'ặ', 'Ằ', 'ằ', 'Ẳ', 'ẳ'),
            'ae'=>	array ('æ', 'Æ'),
            'b'	=>	array ('b', 'B'),
            'c'	=>	array ('c', 'C', 'ç', 'Ç', 'ć', 'Ć', 'č', 'Č'),
            'd'	=>	array ('d', 'D', 'Ð', 'đ', 'Đ', 'ď', 'Ď'),
            'e'	=>	array ('e', 'E', 'è', 'È', 'é', 'É', 'ê', 'Ê', 'ë', 'Ë', 'ę', 'Ę', 'е', 'Е', 'ё', 'Ё', 'э', 'Э', 'Ẹ', 'ẹ', 'Ẻ', 'ẻ', 'Ẽ', 'ẽ', 'Ề', 'ề', 'Ế', 'ế', 'Ệ', 'ệ', 'Ể', 'ể', 'Ễ', 'ễ', 'ε', 'Ε', 'ě', 'Ě'),
            'f'	=>	array ('f', 'F'),
            'g'	=>	array ('g', 'G', 'ğ', 'Ğ'),
            'h'	=>	array ('h', 'H'),
            'i'	=>	array ('i', 'I', 'ì', 'Ì', 'í', 'Í', 'î', 'Î', 'ï', 'Ï', 'ı', 'İ', 'Ị', 'ị', 'Ỉ', 'ỉ', 'Ĩ', 'ĩ', 'Ι', 'ι'),
            'j'	=>	array ('j', 'J'),
            'k'	=>	array ('k', 'K', 'к', 'К', 'κ', 'Κ'),
            'l'	=>	array ('l', 'L', 'ł', 'Ł'),
            'm'	=>	array ('m', 'M', 'м', 'М', 'Μ'),
            'n'	=>	array ('n', 'N', 'ñ', 'Ñ', 'ń', 'Ń', 'ň', 'Ň'),
            'o'	=>	array ('o', 'O', 'ò', 'Ò', 'ó', 'Ó', 'ô', 'Ô', 'õ', 'Õ', 'ö', 'Ö', 'ø', 'Ø', 'º', 'о', 'О', 'Ọ', 'ọ', 'Ỏ', 'ỏ', 'Ộ', 'ộ', 'Ố', 'ố', 'Ỗ', 'ỗ', 'Ồ', 'ồ', 'Ổ', 'ổ', 'Ơ', 'ơ', 'Ờ', 'ờ', 'Ớ', 'ớ', 'Ợ', 'ợ', 'Ở', 'ở', 'Ỡ', 'ỡ', 'ο', 'Ο'),
            'p'	=>	array ('p', 'P'),
            'q'	=>	array ('q', 'Q'),
            'r'	=>	array ('r', 'R', 'ř', 'Ř'),
            's'	=>	array ('s', 'S', 'ş', 'Ş', 'ś', 'Ś', 'š', 'Š'),
            'ss'=>	array ('ß'),
            't'	=>	array ('t', 'T', 'т', 'Т', 'τ', 'Τ', 'ţ', 'Ţ', 'ť', 'Ť'),
            'u'	=>	array ('u', 'U', 'ù', 'Ù', 'ú', 'Ú', 'û', 'Û', 'ü', 'Ü', 'Ụ', 'ụ', 'Ủ', 'ủ', 'Ũ', 'ũ', 'Ư', 'ư', 'Ừ', 'ừ', 'Ứ', 'ứ', 'Ự', 'ự', 'Ử', 'ử', 'Ữ', 'ữ', 'ů', 'Ů'),
            'v'	=>	array ('v', 'V'),
            'w'	=>	array ('w', 'W'),
            'x'	=>	array ('x', 'X', '×'),
            'y'	=>	array ('y', 'Y', 'ý', 'Ý', 'ÿ', 'Ỳ', 'ỳ', 'Ỵ', 'ỵ', 'Ỷ', 'ỷ', 'Ỹ', 'ỹ'),
            'z'	=>	array ('z', 'Z', 'ż', 'Ż', 'ź', 'Ź', 'ž', 'Ž', 'Ζ'),
            $replace=>	array ('-', $plugchar, '.', ',', '!', '~', '*', '$'),
            '_'	=>	array ('_'),
            "\x12"=>	array ("'", '"'),
            '('	=>	array ('(', '{', '['),
            ')'	=>	array (')', '}', ']'),
            '0'	=>	array ('0'),
            '1'	=>	array ('1', '¹'),
            '2'	=>	array ('2', '²'),
            '3'	=>	array ('3', '³'),
            '4'	=>	array ('4'),
            '5'	=>	array ('5'),
            '6'	=>	array ('6'),
            '7'	=>	array ('7'),
            '8'	=>	array ('8'),
            '9'	=>	array ('9'),

    );
    //	Change the entities back to normal characters

    $text = str_replace(array('&amp;', '&quot;'), array('&', '"'), $text);
    $prettytext = '';

    //	Split up $text into UTF-8 letters
    preg_match_all("~.~su", $text, $characters);

    foreach ($characters[0] as $aLetter) {
        foreach ($characterHash as $replace => $search) {
            //	Found a character? Replace it!
            if (in_array($aLetter, $search)) {
                $prettytext .= $replace;
                break;
            }
        }
    }

    //	Remove unwanted '-'s
    $prettytext = preg_replace(array('~^-+|-+$~', '~-+~'), array('', '-'), $prettytext);

    return $prettytext;
}

/* So sanh 2 ngay */
function compare2Date($date1, $date2) {
    if ($date1 == NULL || $date2 == NULL || empty($date1) || empty($date2))
        return false;
    return strtotime($date1) > strtotime($date2) ? true : false;
}

function printError($error) {
    if (!isset($error) || $error == NULL)
        return;

    switch ($error) {
        case "error":
            echo "Lỗi thực hiện chương trình";
            break;
        case "success":
            echo "Thực hiện thành công";
            break;
        case "display":
            echo "Lỗi hiển thị danh sách hoặc danh sách trống";
            break;
    }
}

function printAddEdit($para) {
    if ($para == "edit")
        echo "Hiệu chỉnh";
    else
        echo "Thêm mới";
}

function formatDate($obj, $type="m/d/Y") {
    if ($obj == null)
        return null;
    return $obj->format($type);
}

function inputString($str) {
    if ($str == null)
        return null;
    return addslashes($str);
}

function outputString($str) {
    if ($str == null)
        return null;
    return stripslashes($str);
}

function setTitlePage($str) {
    $str = ($str == "") ? translator('title', 'common') : $str;
    echo "<script type='text/javascript'>document.title = '{$str}'</script>";
}
function getlanguagename($code){
        if ($code =="vn")
            return "Việt Nam";
        return "Tiếng Anh";
    }
    
function buildUrl($link,$arr)
{
  
    foreach ($arr as $value) {
        $link.="/".$value;
    }
    return $link;
}
function getOtherLang()
{
    if (__REQUEST_LANG == 'vn')
        return 'en';
    return 'vn';
}

?>