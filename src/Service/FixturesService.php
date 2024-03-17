<?php

namespace App\Service;

use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FixturesService
{
    public Generator $faker;

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {
        $this->faker = Factory::create('fr_FR');
    }

    public function devicesTables($test = 0): array
    {
        if ($test)
            $file = '../_docs/phonesdata.json';
        else
            $file = getcwd() . '/_docs/phonesdata.json';
        $datas = json_decode(file_get_contents($file), true);
        $headers = array_shift($datas);
        $attrDb = $headers;
        unset($attrDb[19]);
        unset($attrDb[20]);
        array_shift($attrDb);
        $props = [];
        $propDb = [];
        $allProps = [];
        $deviceDb = [];
        $devicePropDb = [];
        $datasReshaped = [];

        foreach ($datas as $k => $row) {
            $image = $row[19];
            unset($row[19]);
            unset($datas[$k][19]);
            $url = $row[20];
            unset($row[20]);
            unset($datas[$k][20]);
            $deviceName = array_shift($row);
            unset($datas[$k][0]);
            $deviceDb[] = [$deviceName, $image, $url, 1];
            foreach ($row as $ka => $col)
                if ($col) {
                    $datasReshaped[$k][$ka] = trim(str_replace(['"', ' , ', "\n", "\t"], '', $col));
                }
            $allProps = array_merge($allProps, $datasReshaped[$k]);
        }
        $props = array_flip(array_flip($allProps));
        sort($props);

        $in_array_id = function ($r, $d) {
            foreach ($r as $k => $v) {
                if ($v == $d)
                    return $k;
            }
        };

        foreach ($datasReshaped as $deviceId => $row) {
            foreach ($row as $attrId => $col) {
                $propId = $in_array_id($props, $col);
                $devicePropDb[] = [$deviceId, $propId];
                $propDb[] = [$attrId, $col];
            }
        }
        $res = [];
        foreach ($devicePropDb as $k => $v) {
            if ($v[0] == 0) {//each prop of device
                $res[0] = $deviceDb[$v[0]] ?? 0;
                $propDevice = $propDb[$v[1]] ?? [];
                $attrId = $propDevice[0];
                $propDevice[0] = $attrDb[$attrId] ?? [];
                $res[] = $propDevice;

            }
        }

        return [$deviceDb, $attrDb, $propDb, $devicePropDb, $res];
    }


}
