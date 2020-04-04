# event
安装libevent库和event库

```
一、安装libevent库
1、wget -c https://github.com/libevent/libevent/releases/download/release-2.1.8-stable/libevent-2.1.8-stable.tar.gz
2、tar -zxvf libevent-2.1.8-stable.tar.gz && cd libevent-2.1.8-stable
3、./configure --prefix=/usr/local/libevent-2.1.8
4、make && make install
如果提示缺少openssl库 如提示configure: error: Cannot find OpenSSL’s libraries
安装openssl库
1、sudo apt-get install openssl   ubuntu环境安装方式
2、find / -name libssl.so  寻找so文件的文章 输出位置如 /usr/lib/x86_64-linux-gnu/libssl.so
3、ln -s /usr/lib/x86_64-linux-gnu/libssl.so /usr/lib  建立软连接到/usr/lib
```
```
二、安装event库
1、wget -c http://pecl.php.net/get/event-2.3.0.tgz
2、tar -zxvf event-2.3.0.tgz && cd event-2.3.0
3、phpize
4、./configure --with-php-config=/usr/local/php7/bin/php-config --with-event-libevent-dir=/usr/local/libevent-2.1.8/  其中--with-php-config参数所设的路径以你php-config实际放置位置为准
5、 make && make install
6、修改php.ini配置文件，添加如下：
  extension=event.so
7、重启fpm
```
