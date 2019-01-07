<?php
/**
 * PureLib (http://purelib.org/)
 *
 * @link      https://github.com/purelib/php-event for the canonical source repository
 * @license   https://github.com/purelib/php-event/blob/master/LICENSE
 */

namespace PureLib\Event;

class StackCollection extends \SplStack
{
    protected $stopped = false;

    public function stop()
    {
        $this->stopped = true;
    }

    public function stopped()
    {
        return $this->stopped;
    }

    public function first()
    {
        return parent::bottom();
    }

    public function last()
    {
        return count($this) === 0 ? null : parent::top();
    }

    public function contains($value)
    {
        foreach ($this as $v) {
            if ($value === $v) {
                return true;
            }
        }
        return false;
    }

    public function success() {
        return ! $this->contains(false);
    }

    public function fail() {
        return $this->contains(false);
    }
}
