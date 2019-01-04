# Event
一个PHP事件管理器。

**参考了 zendframework/zend-eventmanager, 是它的简化版本, 接口并不兼容**

简明使用:

```php

$eventManager = new \PureLib\Event\EventManager();

$eventManager->on('event_name', function($event){
    $target = $event->getTarget();
    $params = $event->getParams();
    
    $param = $event->getParam('key', 'default_value');
    
    //stop
    // $event->stop();
    
    return true;
});

// event_name, target, params
$result = $event->trigger('event_name', null, ['key' => 'value'])->success();

if($result) {
    //ok
} else {
    // error ?
}
```
