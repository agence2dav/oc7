<?php

namespace App\DataFixtures;

use DateTime;
use DateInterval;
use Faker\Factory;
use App\Entity\Attr;
use App\Entity\Prop;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Device;
use App\Entity\DeviceProps;
use App\Service\FixturesService;
use Doctrine\Persistence\ObjectManager;
use Faker\Core\DateTime as FakeDatTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public Generator $faker;
    private array $objects = [];
    private string $adminName = 'd';
    private string $adminMail = 'd@d.d';
    private string $password = 'd';
    private int $numberOfUsers = 4;
    private $month = 12;

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private FixturesService $fixturesService,

    ) {
        $this->faker = Factory::create('fr_FR');
    }

    public function device(ObjectManager $manager, array $deviceDb): void
    {
        foreach ($deviceDb as $dataSet) {
            $device = new Device();
            $device
                ->setName($dataSet[0])
                ->setImage($dataSet[1])
                ->setUrl($dataSet[2])
                ->setStatus($dataSet[3])
            ;
            $this->objects['device'][] = $device;
            $manager->persist($device);
        }
        $manager->flush();
    }

    public function attr(ObjectManager $manager, array $attrDb): void
    {
        foreach ($attrDb as $dataSet) {
            $attr = new Attr();
            $attr->setName($dataSet);
            $this->objects['attr'][] = $attr;
            $manager->persist($attr);
        }
        $manager->flush();
    }

    public function prop(ObjectManager $manager, array $propDb): void
    {
        $id = 0;
        foreach ($propDb as $dataSet) {
            $prop = new Prop();
            $prop
                ->setAttr($this->objects['attr'][$dataSet[0]])
                ->setName($dataSet[1])
            ;
            $this->objects['prop'][] = $prop;
            $manager->persist($prop);
        }
        $manager->flush();
    }

    public function deviceProps(ObjectManager $manager, array $devicePropDb): void
    {
        foreach ($devicePropDb as $dataSet) {
            $deviceProps = new DeviceProps();
            $deviceProps
                ->setDevice($this->objects['device'][$dataSet[0]])
                ->setProp($this->objects['prop'][$dataSet[1]])
            ;
            $manager->persist($deviceProps);
        }
        $manager->flush();
    }

    public function users(ObjectManager $manager): void
    {
        for ($i = 0; $i < $this->numberOfUsers; $i++) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, $this->password);
            $user
                ->setUsername($i == 0 ? $this->adminName : $this->faker->username)
                ->setEmail($i == 0 ? $this->adminName : $this->faker->email)
                ->setPassword($password)
                ->setRoles([$i == 0 ? 'ROLE_ADMIN' : 'ROLE_EDIT']);
            $this->objects['user'][] = $user;
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function load(ObjectManager $manager): void
    {
        [$deviceDb, $attrDb, $propDb, $devicePropDb] = $this->fixturesService->devicesTables();
        //dd($deviceDb);
        $this->device($manager, $deviceDb);
        $this->attr($manager, $attrDb);
        $this->prop($manager, $propDb);
        $this->deviceProps($manager, $devicePropDb);
        //$this->users($manager);
    }
}
