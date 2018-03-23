<?php
declare(strict_types=1);

namespace Tests\App\Zoo\Animals;

use App\Zoo\Animal;
use App\Zoo\Aviaries\CatsAviary;
use App\Zoo\Food;
use App\Zoo\VitalActivities\MovingActivity;

class WildCatTest extends AbstractAnimal
{
    public function setUp()
    {
        parent::setUp();

        $this->animalInstance = CatsAviary::makeWildCat(
            $this->animalName,
            $this->animalSize,
            $this->animalFoodRation
        );
    }

    /**
     * Must be overridden in children classes
     *
     * @return Animal
     */
    protected function getVictimAnimal(): Animal
    {
        return CatsAviary::makeWildCat('"Victim test wild cat"', 10, new Food(20));
    }

    public function testWalkActivity()
    {
        // Activity status
        $status = MovingActivity::STATUS_WALK;

        // Run "walk" function
        $this->animalInstance->walk();

        // Test status
        $this->assertEquals($status, $this->animalInstance->getActivityStatus());
    }

    public function testRunActivity()
    {
        // Activity status
        $status = MovingActivity::STATUS_RUN;

        // Run "run" function
        $this->animalInstance->run();

        // Test status
        $this->assertEquals($status, $this->animalInstance->getActivityStatus());
    }

    public function testJumpActivity()
    {
        // Activity status
        $status = MovingActivity::STATUS_JUMP;

        // Run "jump" function
        $this->animalInstance->jump();

        // Test status
        $this->assertEquals($status, $this->animalInstance->getActivityStatus());
    }
}
