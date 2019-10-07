<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CardFixtures extends Fixture
{
     

    public function load(ObjectManager $manager)
    {
        $url = "https://db.ygoprodeck.com/api/v5/cardinfo.php?la=french";
        $infos = file_get_contents($url);
        $cards = json_decode($infos);
        
        foreach ($cards as $card) {
            $product = new Products();
            $product->set
        }
        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
