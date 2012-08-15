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

    function paginate($offset, $total, $limit, $base = '') {
        $next ="Tiếp";
        $previous ="Trước";
        if ($total == 0 || $total == 1) {
            return;
        }
        

        $lastp = ceil($total / $limit);
        $thisp = ceil(($offset == 0 ? 1 : ($lastp / ($total / $offset))));
        print "    <div class=\"paginator\">\n";

        if ($offset != 2 && $offset != 1) {
            if ($thisp == 1) {
                print "      <SPAN CLASS=\"atstart\"> $previous</SPAN>\n";
            } else {
                print "      <a class='number' href=\"" . $base . ((($thisp - 2) * $limit) + 1) . "\" class=\"prev\"> $previous</a> \n";
            }
        }
        $page1 = $base . "1";
        $page2 = $base . ($limit + 1);
        if ($thisp <= 5) {
            for ($p = 1; $p <= min(($thisp <= 3) ? 5 : $thisp + 2, $lastp); $p++) {
                if ($p == $thisp) {
                    print "      <span class=\"this-page\">$p</span>\n ";
                } else {
                    $url = $base . (($limit * ($p - 1)) + 1);
                    print "      <a class='number' href=\"$url\">$p</a>\n ";
                }
            }
            if ($lastp > $p) {
                
                print "      <span class=\"break\">...</span>\n";
                print "      <a class='number' href=\"" . $base . ((($lastp - 1) * $limit) ) . "\">" . ($lastp - 1) . "</a>\n";
                print "      <a class='number' href=\"" . $base . (($lastp * $limit) ) . "\">" . $lastp . "</a>\n";
            }
        } else if ($thisp > 5) {
            print "      <a class='number' href=\"" . $page1 . "\">1</a> <a class='number' href=\"" . $page2 . "\">2</a>";
            if ($thisp != 6) {
                print " <span class=\"break\">...</span>\n ";
            }
            for ($p = ($thisp == 6) ? 3 : min($thisp - 2, $lastp - 4); $p <= (($lastp - $thisp <= 5) ? $lastp : $thisp + 2); $p++) {
                if ($p == $thisp) {
                    print "      <span class=\"this-page\">$p</span>\n ";
                } else if ($p <= $lastp) {
                    $url = $base . (($limit * ($p - 1)) + 1);
                    print "      <a class='number' href=\"$url\">$p</a>\n ";
                }
            }
            if ($lastp > $p + 1) {
                print "      <span class=\"break\">...</span>\n";
                print "      <a class='number' href=\"" . $base . ((($lastp - 1) * $limit) + 1) . "\">" . ($lastp - 1) . "</a>\n";
                print "      <a class='number' href=\"" . $base . (($lastp * $limit) + 1) . "\">" . $lastp . "</a>\n";
            }
        }

        if ($offset != $total && $offset!=($total -1) ) {
            if ($thisp == $lastp) {
                print "      <SPAN CLASS=\"atend\"> $next </SPAN>\n";
            } else {
                print "      <a class='number' href=\"" . $base . ((($thisp + 0) * $limit) + 1) . "\" class=\"next\">$next </a>\n";
            }
        }
        print "    </div>\n";
    }

}

?>
