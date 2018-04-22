<?php

/**
 * Zoo.php
 *
 * PHP version 7.0
 *
 * Class Zoo provides a pool for animals
 *
 * @author Igor S <igor.shp@i.ua>
 */

namespace App\Zoo;

/**
 * @class Zoo
 */
class Zoo
{
    /**
     * @var array - animals pool (is empty by default)
     */
    private $pool = [];

    /**
     * @var AnimalServant
     */
    private $animalServant;

    /**
     * Zoo constructor.
     *
     * @param array $animals
     *
     * @return void
     */
    public function __construct(array $animals = [])
    {
        $this->animalServant = new AnimalServant();
        if (!empty($animals)) {
            foreach ($animals as $animalName) {
                $this->addAnimal($animalName);
            }
        }
    }

    /**
     * Add animal to the pool
     *
     * @param string $animalName
     *
     * @return void
     */
    public function addAnimal(string $animalName)
    {
        try {
            $this->pool[] = AnimalFactory::create($animalName);
        } catch (\Exception $e) {
            trigger_error(
                'Can not add animal ' . var_export($animalName) . ' to the zoo. Error: ' . $e->getMessage(),
                E_USER_WARNING
            );
        }
    }

    /**
     * Get animal from the pool
     *
     * @return \Iterator
     */
    public function getAnimal() : \Iterator
    {
        foreach ($this->pool as $animal) {
            yield $animal;
        }
    }

    /**
     * Treat animals in the zoo
     *
     * @return string
     */
    public function treatAnimals()
    {
        $result = '';
        foreach ($this->getAnimal() as $animal) {
            $result .= $this->animalServant->treat($animal);
        }
        return $result;
    }
}
