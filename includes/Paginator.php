<?php

/*
 * Copyright (c) 2006-2008 Byrne Reese. All rights reserved.
 * 
 * This library is free software; you can redistribute it and/or modify it 
 * under the terms of the BSD License.
 *
 * This library is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 *
 * @author Byrne Reese <byrne@majordojo.com>
 * @version 1.01
 */

class Paginator {

    function paginate($curr_page, $total, $limit, $base = '') {
        $num_page = intval($total /$limit);
        if (($total % $limit) >0)
            $num_page ++;
        $index_page = 1;
        echo '<div id="cotainer_number">';
        if ($curr_page>1)
        {
            $index_page = $curr_page-1;
            print "<a class='previous' href='{$base}/$index_page' >previous</a>";
            print "<a class='index' href='{$base}/$index_page' >$index_page</a>";
        }
        else
        {
             print "<a class='previous'>previous</a>";
            print "<a class='index invisible'  >$index_page</a>";
        }
        
          print "<a class='index current' >$curr_page</a>";
       
         if ($curr_page<$num_page)
        {
            $index_page = $curr_page+1;
            print "<a class='index' href='{$base}/$index_page' >$index_page</a>";
            print "<a class='next' href='{$base}/$index_page' >next</a>";
        }
        else
        {
             print "<a class='index invisible' >$index_page</a>";
             print "<a class='next' >next</a>";
        }
        
        echo '</div>';
    }

}

?>
