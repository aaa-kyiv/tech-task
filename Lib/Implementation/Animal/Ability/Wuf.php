<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: danchukas
 * Date: 2018-03-21 23:22
 */

namespace DanchukAS\Implementation\Animal\Ability;

use DanchukAS\Scheme\Animal\Ability\WufableInterface;

class Wuf extends Ability
{
    public function __construct(WufableInterface $object)
    {
        parent::__construct($object);
    }
}