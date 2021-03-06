<?php

namespace App\DataFixtures;

use App\Entity\Images;
use App\Entity\Stock;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
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
            if (array_key_exists('card_sets', $card)) {
                foreach ($card->card_sets as $set) {
                $product = new Products();
                $product->setName($card->name)
                        ->setType($card->type)
                        ->setRace($card->race)
                        ->setDescription($card->desc)
                        ->setSetName($set->set_name)
                        ->setSetCode($set->set_code)
                        ->setSetRarity($set->set_rarity)
                        ->setPrice($set->set_price)
                        ->setCost(intval($set->set_price)/2);
                
                if (array_key_exists('archetype', $card)) {
                    $product->setArchetype($card->archetype);
                }
                if (array_key_exists('atk', $card)) {
                    $product->setAtk($card->atk)
                            ->setDef($card->def)
                            ->setLevel($card->level)
                            ->setAttribute($card->attribute);
                }

                $manager->persist($product);

                if (array_key_exists('card_images', $card)) {
                    foreach ($card->card_images as $cardImage) {

                        $image = new Images();
                        $image  ->setUrl($cardImage->image_url)
                                ->setUrlSmall($cardImage->image_url_small)
                                ->addProductsId($product);

                        $manager->persist($image);
                    }
                }
                // $stock = new Stock();

                // $stock->setCardId($product)
                //     ->setStockType('Française')
                //     ->setNew(3)
                //     ->setCorrect(3)
                //     ->setOccasion(3)
                //     ->setAbimee(3);

                // $manager->persist($stock);

                }
            }else{
                $product = new Products();
                $product->setName($card->name)
                        ->setType($card->type)
                        ->setRace($card->race)
                        ->setDescription($card->desc);
    
                if (array_key_exists('archetype', $card)) {
                    $product->setArchetype($card->archetype);
                }
                if (array_key_exists('atk', $card)) {
                    $product->setAtk($card->atk)
                            ->setDef($card->def)
                            ->setLevel($card->level)
                            ->setAttribute($card->attribute);
                }
                $manager->persist($product);

                if (array_key_exists('card_images', $card)) {
                    foreach ($card->card_images as $cardImage) {

                        $image = new Images();
                        $image  ->setUrl($cardImage->image_url)
                                ->setUrlSmall($cardImage->image_url_small)
                                ->addProductsId($product);
                        $manager->persist($image);
                    }
                }

                // $stock = new Stock();

                // $stock->setCardId($product)
                //     ->setStockType('Française')
                //     ->setNew(3)
                //     ->setCorrect(3)
                //     ->setOccasion(3)
                //     ->setAbimee(3);

                // $manager->persist($stock);
            }

        }

        $manager->flush();
    }
}
