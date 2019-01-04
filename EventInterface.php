<?php
/**
 * PureLib (http://purelib.org/)
 *
 * @link      https://github.com/purelib/php-event for the canonical source repository
 * @license   https://github.com/purelib/php-event/blob/master/LICENSE
 */

namespace PureLib\Event;

interface EventInterface
{
    public function stop();
    public function stopped();
    public function getManager();
    public function getName();
    public function getTarget();
    public function getParams();
}