<?php

namespace App\Service;

use DateTime;
use DateInterval;
use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Faker\Core\DateTime as FakeDatTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FixturesService
{

    public Generator $faker;
    private $month = 12;

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {
        $this->faker = Factory::create('fr_FR');
    }

    public function generateDateInPast(): DateTime
    {
        $this->month = mt_rand(1, 24);
        $now = new DateTime();
        $dist = DateInterval::createFromDateString($this->month . ' months');
        $now->sub($dist);
        $now->format('Y-m-d H:i:s');
        return $now;
    }

    public function test(): void
    {
        $file = '../_docs/phonesdata.json';
        $datas = json_decode(file_get_contents($file), true);
        $headers = array_shift($datas);
        $attrDb = $headers;
        $props = [];
        $propDb = [];
        $deviceDb = [];
        $devicePropDb = [];

        foreach ($datas as $k => $row) {
            $image = $row[19];
            unset($row[19]);
            $url = $row[20];
            unset($row[20]);
            $device[] = [array_shift($row), $image, $url, 1];
            foreach ($row as $ka => $col) {
                $props[] = trim(str_replace(['"', ' , ', "\n", "\t"], '', $col));
            }
        }
        $props = array_flip(array_flip($props));
        sort($props);

        $in_array_id = function ($r, $d) {
            foreach ($r as $k => $v) {
                if ($v == $d)
                    return $k;
            }
        };

        foreach ($datas as $k => $row) {
            foreach ($row as $ka => $col) {
                $propId = $in_array_id($props, $col);
                $devicePropDb[] = [$k, $propId];
                $propDb[] = [$ka, $col];
            }
        }

        dd($attrDb, $deviceDb, $propDb, $devicePropDb);
    }


}
