<?php

interface Event {}

class SomeEvent implements Event {}
class AnotherEvent implements Event {}

class Dispatcher {
    // protected array $dispatchCount; // An array cannot have object key
    protected WeakMap $dispatchCount;

    public function __construct()
    {
        // $this->dispatchCount = [];
        $this->dispatchCount = new WeakMap();
    }

    public function dispatch(Event $event)
    {
        $this->incrementDispatches($event);
        // dispatch the event
    }

    public function incrementDispatches(Event $event)
    {
        // if (!isset($this->dispatchCount[$event])) {
        //     $this->dispatchCount[$event] = 0;
        // }

        $this->dispatchCount[$event] ??= 0;
        $this->dispatchCount[$event]++;        
    }
}

$dispatcher = new Dispatcher();

$event = new SomeEvent();
$dispatcher->dispatch($event);
$dispatcher->dispatch($event);

$anotherEvent = new AnotherEvent();
$dispatcher->dispatch($anotherEvent);

var_dump($dispatcher);