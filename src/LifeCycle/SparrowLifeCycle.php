<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: danchukas
 * Date: 2018-03-23 20:53
 */
class SparrowLifeCycle extends \EatLifeCycle
{
    public function run($object)
    {
        $this->lib->callAction($object, 'walk');
        $this->lib->callAction($object, 'tweet');
        $this->lib->callAction($object, 'fly');

        parent::run($object);
    }
}