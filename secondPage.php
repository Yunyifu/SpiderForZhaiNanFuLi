<?php
/**
 * Created by PhpStorm.
 * User: yifu
 * Date: 2017-10-8
 * Time: 17:57
 */

/**
 * 获取二级连接的内容，例如：http://fulimomo.net/63117.html
 */

function secondPage($link){
    $header = array();
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$link);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //在这里插入你的cookie
    curl_setopt($ch,CURLOPT_COOKIE,'/*这里*/');

    $content = curl_exec($ch);

    preg_match("#http://.*dvd.*txt#",$content,$match);

    if(empty($match)){
        $txt = '';
    }else{
        $txt = file_get_contents($match[0]);
    }
    //var_dump($txt);
    return $txt;
}

//secondPage('http://fulimomo.net/wp-admin/profile.php');
