<?php

namespace App\DataFixtures;

use DateTime;
use DateInterval;
use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
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
        //private FixturesService $fixturesService,

    ) {
        $this->faker = Factory::create('fr_FR');
    }

    public function mobiles(ObjectManager $manager): void
    {
        $file = getcwd() . '/_docs/phonesdata.csv';
        //$datas = $this->fixturesService->getCsv($file);
        $file = getcwd() . '/_docs/phonesdata.json';
        $datas = json_decode(file_get_contents($file));

        $this->objects['images'] = $file;
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
        $this->mobiles($manager);
        $this->users($manager);
    }
}
