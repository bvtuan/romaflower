<?php

class cache {

    public function __construct() {
        if (!defined('CACHE_PATH'))
            define('CACHE_PATH', __SITE_PATH . '/caches');
    }

    /*
     * $id is the key to save cache
     * $time is calculated by minutes
     * $content is the content will be cached.
     */

    public function getCache($id) {
        $file_cache = CACHE_PATH . "/$id.cache";
        if (!file_exists($file_cache))
            die("File $file_cache not found");

        $content = file_get_contents($file_cache);

        return unserialize($content);
    }

    public function save($id, $time, $content) {
        if (!__ENABLE_CACHE)
            return;

        $file_info = CACHE_PATH . "/$id.info";
        $file_cache = CACHE_PATH . "/$id.cache";

        //Equal current time add the long time
        $time = time() + ($time * 60);

        $handle = fopen($file_info, 'w+');
        if (!fwrite($handle, $time))
            return false;
        fclose($handle);

        $content = serialize($content);

        $handle = fopen($file_cache, 'w+');
        if (!fwrite($handle, $content))
            return false;
        fclose($handle);
    }

    public function isValid($id) {
        $file_info = CACHE_PATH . "/$id.info";

        if (!file_exists($file_info))
            return false;
        $file_time = file_get_contents($file_info);
        return (time() < $file_time);
    }

    /*
     * $id : the id need to remove
     * If $id is null, remove all cache in cache folder 
     */
    public function remove($id = null) {
        if ($id == null) {
            
            if ($handle = opendir(CACHE_PATH)) {
                while (false !== ($file = readdir($handle))) {
                    $file_path =CACHE_PATH.'/'.$file;
                    if (file_exists($file_path) && is_file($file_path))
                    {
                        unlink($file_path);
                    }
                }
            }
        }
        else
        {
              $file_info = CACHE_PATH . "/$id.info";
              $file_cache = CACHE_PATH . "/$id.cache";
              if (file_exists($file_info))
                  unlink ($file_info);
              
              if (file_exists($file_cache))
                  rmdir($file);
        }
    }

}