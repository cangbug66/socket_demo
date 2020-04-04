<?php

class Timer{
    public $eventConfig;
    public $eventBase;
    public function __construct()
    {
        $this->eventConfig = new EventConfig();
        $this->eventBase = new EventBase($this->eventConfig);
    }

    public function interval($time,Closure $closure)
    {
        $time = $time > 0 ? $time:1;
        $closure = $closure instanceof Closure?$closure:function(){};
        $timer = new Event( $this->eventBase, -1, Event::TIMEOUT | Event::PERSIST, $closure );
        $timer->add( $time );
        $this->loop();
    }

    public function timeout($time,Closure $closure)
    {
        $time = $time > 0 ? $time:1;
        $closure = $closure instanceof Closure?$closure:function(){};
        $timer = new Event( $this->eventBase, -1, Event::TIMEOUT , $closure );
        $timer->add( $time );
        $this->loop();
    }

    public function loop()
    {
        $this->eventBase->loop();
    }

}

//$timer = new Timer();

//$timer-> timeout(-2,function () {
//    echo date("Y-m-d H:i:s",time())."定时器一次\n";
//});
//$timer-> interval(-2,function () {
//    echo date("Y-m-d H:i:s",time())."定时器\n";
//});


echo "asd"."\x20";