<?php
/**
 * PureLib (http://purelib.org/)
 *
 * @link      https://github.com/purelib/php-event for the canonical source repository
 * @license   https://github.com/purelib/php-event/blob/master/LICENSE
 */

namespace PureLib\Event;

class EventManager
{
    protected $eventPrototype;
    protected $listeners = array();
    protected $stop = false;

    public function setEventPrototype($prototype)
    {
        $this->eventPrototype = $prototype;
    }

    public function __construct($sharedEventManager = null)
    {
        $this->eventPrototype = new Event();
    }

    public function on($event_name, $listener, $priority = 0)
    {
        // todo class
        if (!is_callable($listener)) {
            return false;
        }

        if (!isset($this->listeners[$event_name])) {
            $this->listeners[$event_name] = new \SplPriorityQueue();
        }

        /* @var $q \SplPriorityQueue */
        $q = $this->listeners[$event_name];
        $q->insert($listener, $priority);

        return true;
    }

    public function trigger($event_name, $target = null, $params = array(), $callback = null)
    {
        if (!isset($this->listeners[$event_name])) {
            $collection = new StackCollection();
            return false;
        }

        $event = clone $this->eventPrototype;
        $event->setName($event_name);

        if ($target !== null) {
            $event->setTarget($target);
        }

        if ($params !== null) {
            $event->setParams($params);
        }

        return $this->triggerListeners($event, $callback);
    }

    public function triggerListeners(EventInterface $event, $callback = null)
    {
        if ($callback !== null && !is_callable($callback)) {
            return false;
        }

        $event_name = $event->getName();
        $listeners = $this->listeners[$event_name];
        $listeners->setExtractFlags(\SplPriorityQueue::EXTR_DATA);
        $collection = new StackCollection();

        while (!$collection->stopped() && $listeners->valid()) {
            $listener = $listeners->current();

            $_ = $listener($event);

            $collection->push($_);

            if ($event->stopped()) {
                $collection->stopped();
                break;
            }

            if ($callback && $callback($_)) {
                $collection->stop();
                return $collection;
            }

            $listeners->next();
        }

        return $collection;
    }
}
