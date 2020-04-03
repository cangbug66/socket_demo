<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/4/3
 * Time: 16:47
 */
//创建tcp socket
$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

$host="127.0.0.1";
$port=6666;
//绑定ip和端口
 socket_bind($socket,$host,$port);


//开始监听socket
socket_listen($socket);


while (true){
    $conn_socket=socket_accept($socket);
    $content = "hello world 时间：".date("Y-m-d H:i:s",time());
    $data = socket_read($conn_socket,1024);
    echo "收到消息：".$data."\n";
    socket_write($conn_socket,$content,strlen($content));
    socket_close($conn_socket);
}


socket_close($socket);