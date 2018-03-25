<?php
declare(strict_types=1);

namespace DanchukAS\AmadeusTechTask123\Lib;


class GetAnimalCollection extends \LibFunction
{

    public function run(\IHasAnimalCollection $object)
    {
        return $object->animalCollection;
    }

}