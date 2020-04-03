<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/4/3
 * Time: 16:55
 */

$host = "127.0.0.1";
$port = 6666;

    $fp=stream_socket_client(sprintf("tcp://%s:%s",$host,$port), $errno, $errstr);
    if(!$fp)
    {
        echo "err : $errno - $errstr<br />n";
    }
    else {
        fwrite($fp, "this is client");
        $response = fread($fp, 1024);
        echo "收到消息：" . $response."\n";
    }
    fclose($fp);

