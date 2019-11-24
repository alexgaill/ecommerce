<?php

namespace App\DataFixtures;

use App\Entity\Entry;
use App\Entity\Arrivage;
use App\Repository\StockRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArrivageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $repositori = new UserRepository;
        // $repo = new StockRepository;

        // $user = $repositori->find(1);

        // $arrivage = new Arrivage;

        // $arrivage->setName('1er arrivage')
        //         ->setCreatedAt(new \DateTime)
        //         ->setIdClient($user->getId())
        //         ->setType('achat')
        //         ->setTotalTTC(25);

        //         $manager->persist($arrivage);

        // for ($i=0; $i < 2; $i++) { 
        //     $stock = $repo->find($i);
        //     $entry = new Entry;
        //     $entry  ->setIdArrivage($arrivage->getId())
        //             ->setIdStock($stock->getId())
        //             ->setNew(2)
        //             ->setCorrect(1)
        //             ->setOccasion(0)
        //             ->setAbimee(1)
        //             ->setTotalTTC(12,5);
            
        //     $manager->persist($entry);
        // }


        // $manager->flush();
    }
}
