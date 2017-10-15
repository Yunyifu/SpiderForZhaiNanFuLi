<?php
header ( "Content-type:text/html;charset=utf-8" );
/**
 * Created by yunyifu.
 * Date: 2017-10-8
 * Time: 14:32
 */
require ('secondPage.php');
//请使用控制台运行本程序
//ini_set('max_execution_time','300');

//需要采集的页面数量
$pageNum = 3;

for($j = 1;$j <= $pageNum; $j++){
    echo "begin spider,now page num is $j\n";
    $web = file_get_contents("http://fulimomo.net/page/$j");
    spider($web);
}

function spider($web){


    preg_match_all("#fs24 f_w.*rel#",$web,$match,PREG_PATTERN_ORDER);


    $url = [];
    $title = [];

    foreach ($match[0] as $value){
        preg_match("#http.+html#",$value,$url[]);
        preg_match("#title.+rel#",$value,$title[]);
    }


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "spider";
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
// 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }


    for ($i=0;$i<count($url);$i++){
        $txt = secondPage($url[$i][0]);
        $a = $url[$i][0];
        $b = $title[$i][0];

        $sql = "INSERT INTO fulisoso (link, title, download_txt) VALUES ('$a', '$b', '$txt')";
        if ($conn->query($sql) === TRUE) {
            echo "insert $i success  \n";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    //关闭数据库连接
    $conn->close();
}





