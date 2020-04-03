<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/4/3
 * Time: 16:47
 */
//创建tcp socket

$server_socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

$host="127.0.0.5";
//$host="0.0.0.0";
$port=6666;
//绑定ip和端口
 socket_bind($server_socket,$host,$port);
//开始监听socket
socket_listen($server_socket);

$conn_clients = [$server_socket];

$write=[];
$exp=[];

function signal_handler(){
    global $server_socket;
    socket_close($server_socket);
    exit;
}
pcntl_signal(SIGTERM, 'signal_handler');
pcntl_signal(SIGINT, 'signal_handler');
while (true){
    $reads = $conn_clients;

    if (@socket_select($reads,$write,$exp,null) > 0){
        if(in_array($server_socket,$reads)){// 判断listen_socket有没有发生变化，如果有就是有客户端发生连接操作了
            $conn_socket = socket_accept($server_socket);
            $conn_clients[] = $conn_socket;
            $key = array_search($server_socket,$reads);
            unset($reads[$key]);//把$server_socket从reads中剔除
        }
        if(count($reads) > 0){
            $msg_content = "服务端收到消息的时间：".date("Y-m-d H:i:s",time());
            foreach ($reads as $conn_socket_item){
                var_dump("fd:".$conn_socket_item);
                $receive_content = socket_read($conn_socket_item,2048);
                $c= $msg_content." 你发送过来的消息：".$receive_content;
                socket_write( $conn_socket_item, $c, strlen($c) );
            }
        }
    }else{
        continue;
    }

}



//socket_close($server_socket);






