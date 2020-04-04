<?php

$host = '0.0.0.0';
$port = 6666;
$listen_socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
socket_bind( $listen_socket, $host, $port );
socket_listen( $listen_socket );
//设置为非阻塞
socket_set_nonblock( $listen_socket );

$event_config = new EventConfig();
$event_base = new EventBase($event_config);
$event = new Event( $event_base, $listen_socket, Event::READ | Event::PERSIST,function ($listen_socket){
    if( ( $connect_socket = socket_accept( $listen_socket ) ) != false){
        echo "有新的客户端：".intval( $connect_socket ).PHP_EOL;
        $content=socket_read($connect_socket,2048);
        $msg = "hello i an socket_event 你发的消息是：".$content;
        socket_write( $connect_socket, $msg, strlen( $msg ) );
        socket_close( $connect_socket );
    }
},$listen_socket);
$event->add();
$event_base->loop();
