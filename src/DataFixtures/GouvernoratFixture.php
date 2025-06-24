<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Gouvernorat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GouvernoratFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $gouvernoratCities = [
            'Tunis' => ['Tunis', 'Centre Urbain', 'Carthage'],
            'Ariana' => ['Borj Louzir', 'Riadh Andalos', 'Ariana Ville'],
            'Sousse' => ['Sousse Ville', 'Kssar Hlal'],
            'Kasserine' => ['Fernana'],
            'Sfax' => ['Sfax ville', 'Sakyet Ezit'],
            'Mednine' => ['Djerba'],
        ];
        foreach($gouvernoratCities as $gouv => $cities ) {
            $gouvernorat = new Gouvernorat();
            $gouvernorat->setName($gouv);
            foreach ($cities as $cityName) {
                $city = new City();
                $city->setName($cityName);
                $gouvernorat->addCity($city);
            }
            $manager->persist($gouvernorat);
        }
        $manager->flush();
    }
}
