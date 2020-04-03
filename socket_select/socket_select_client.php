<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/4/3
 * Time: 16:55
 */

$host = "127.0.0.5";
$port = 6666;

    $fp=stream_socket_client(sprintf("tcp://%s:%s",$host,$port), $errno, $errstr);
    if(!$fp)
    {
        echo "erreur : $errno - $errstr<br />n";
    }
    else {
        while (true){
            fwrite($fp, "this is client ".time());
            $response = fread($fp, 1024);
            echo "收到来自服务端消息：" . $response."\n";
            sleep(2);
        }
    }
    fclose($fp);

