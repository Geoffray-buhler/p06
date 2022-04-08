<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $DictionnaireCategories = [
            "Grabs","Rotations",'Flips','Rotations désaxées','Slides','One foot tricks','Old school','Sauts','Barre de slide'
        ];

        foreach ($DictionnaireCategories as $key => $DictionnaireCategorie) {
            $trick = new Categorie;
            $trick->setName($DictionnaireCategorie);
            $manager->persist($trick);
        }

        $manager->flush();
    }
}