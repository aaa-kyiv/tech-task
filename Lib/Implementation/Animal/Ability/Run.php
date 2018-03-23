<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: danchukas
 * Date: 2018-03-21 23:21
 */

namespace DanchukAS\Implementation\Animal\Ability;


use DanchukAS\Scheme\Animal\Ability\RunableInterface;


class Run extends Ability
{
    public function __construct(RunableInterface $object)
    {
        parent::__construct($object);
    }
}