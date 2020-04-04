<?php

$host = '127.0.0.7';
$port = 6666;
$listen_socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
socket_bind( $listen_socket, $host, $port );
socket_listen( $listen_socket );
//设置为非阻塞
socket_set_nonblock( $listen_socket );

$events_arr = [];//事件集合
$conns_arr = [];//连接socket集合




$event_config = new EventConfig();
$event_base = new EventBase($event_config);
$event = new Event( $event_base, $listen_socket, Event::READ | Event::PERSIST,
    function ($listen_socket){
    global $events_arr,$conns_arr,$event_base;

    if( ( $connect_socket = socket_accept( $listen_socket ) ) != false){
        // 将connect_socket也设置为非阻塞模式
        socket_set_nonblock( $connect_socket );
        $conns_arr[ intval( $connect_socket ) ] = $connect_socket;
        $personNum_msg = "=====".count($conns_arr)."人=====\n";
        foreach ($conns_arr as $conn){
            $personNum_msg .= "socketID:".intval($conn)."\n";
        }
        $personNum_msg .= "=============\n";
        $welcome_msg = date('Y-m-d H:i:s')." 欢迎来到socket_event聊天室,你的socketID为：".intval( $connect_socket ).PHP_EOL;
        socket_write( $connect_socket, $welcome_msg.$personNum_msg, strlen( $welcome_msg.$personNum_msg ) );

        foreach( $conns_arr as $conn_key => $conn_item ){
            if( $connect_socket != $conn_item ){
                $msg = "socketID_".intval( $connect_socket ).'加入房间'."\n";
                socket_write( $conn_item, $msg, strlen( $msg ) );
            }
        }

        $event = new Event( $event_base, $connect_socket, Event::READ | Event::PERSIST,function ($connect_socket){
            global $conns_arr;

            $buffer = socket_read( $connect_socket, 65535 );
            foreach( $conns_arr as $conn_key => $conn_item ){
                if( $connect_socket != $conn_item ){
                    $msg = "socketID_".intval( $connect_socket ).'说 : '.$buffer."\n";
                    socket_write( $conn_item, $msg, strlen( $msg ) );
                }
            }
        },$connect_socket);
        $event->add();
        $events_arr[ intval( $connect_socket ) ] = $event;
    }
},$listen_socket);
$event->add();
$event_base->loop();

//ctrl+z 退出脚本

