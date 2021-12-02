<?php

namespace Evrinoma\VacationBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\VacationBundle\Entity\User\BaseUser;

final class UserFixtures extends Fixture implements FixtureGroupInterface, OrderedFixtureInterface
{
//region SECTION: Fields
    private array $data = [
        ['identity' => 'user0', 'role' => ['ROLE_USER']],
        ['identity' => 'user1', 'role' => ['ROLE_USER']],
        ['identity' => 'user2', 'role' => ['ROLE_USER']],
        ['identity' => 'manger0', 'role' => ['ROLE_USER', 'ROLE_RESOLVER']],
        ['identity' => 'manger1', 'role' => ['ROLE_USER', 'ROLE_RESOLVER']],
        ['identity' => 'manger2', 'role' => ['ROLE_USER', 'ROLE_RESOLVER']],
    ];
//endregion Fields

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->createTypes($manager);

        $manager->flush();
    }
//endregion Public

//region SECTION: Private
    private function createTypes(ObjectManager $manager)
    {
        $short = (new \ReflectionClass(BaseUser::class))->getShortName()."_";
        $i     = 0;

        foreach ($this->data as $record) {
            $entity = new BaseUser();
            $entity
                ->setIdentity($record['identity'])
                ->setRole($record['role']);

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            $i++;
        }

        return $this;
    }

//endregion Private

//region SECTION: Getters/Setters
    public static function getGroups(): array
    {
        return [
            FixtureInterface::USER_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}