<?php
/**
 * PureLib (http://purelib.org/)
 *
 * @link      https://github.com/purelib/php-event for the canonical source repository
 * @license   https://github.com/purelib/php-event/blob/master/LICENSE
 */

namespace PureLib\Event;

class Event implements EventInterface
{
    protected $manager;
    protected $name;
    protected $target;
    protected $params;
    protected $stopped = false;

    public function __construct()
    {
    }

    public function stop()
    {
        $this->stopped = true;
    }

    public function stopped()
    {
        return $this->stopped;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getParam($name, $default = null)
    {
        if (is_array($this->params) || $this->params instanceof ArrayAccess) {
            if (! isset($this->params[$name])) {
                return $default;
            }
            return $this->params[$name];
        }
        if (! isset($this->params->{$name})) {
            return $default;
        }
        return $this->params->{$name};
    }

    public function setParam($name, $value)
    {
        if (is_array($this->params) || $this->params instanceof \ArrayAccess) {
            $this->params[$name] = $value;
        } else {
            $this->params->{$name} = $value;
        }
    }
}