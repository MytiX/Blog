<?php

namespace App\Controller;

use App\Entity\User;
use ReflectionClass;
use App\Core\Route\Route;
use App\Core\ORM\ActiveRecord;
use App\Core\Controller\AbstractController;
use App\Core\ORM\ORMReflection;

class HomeController extends AbstractController
{
    #[Route("/")]
    public function home()
    {
        $user = new User();

        $user->setId(6);
        $user->setName("José");
        $user->setNomArticle("Mon beau PHP");
        
        
        $orm = new ORMReflection($user);
        
        dd($orm->getTable(), $orm->getColumns(), $orm->getValues());





        
        // $result = $user->findById(1);
        // $user->setName("Jose");
        // $user->setPrenom("Henry");
        // $user->setAge(25);

        // $reflection = new ReflectionClass($user);

        // dd($reflection->getProperties());

        // $user->insert();

        // $users = $entityManager->findAll($user);

        // dd($users[1]->getName());



        // Votre nom et votre prénom ;
        // Une photo et/ou un logo ;
        // Une phrase d’accroche qui vous ressemble (exemple : “Martin Durand, le développeur qu’il vous faut !”)
        // Un menu permettant de naviguer parmi l’ensemble des pages de votre site web ;
        // Un formulaire de contact (à la soumission de ce formulaire, un e-mail avec toutes ces informations vous sera envoyé) avec les champs suivants :
        // Nom/prénom,
        // E-mail de contact,
        // message,
        // Un lien vers votre CV au format PDF ;
        // Et l’ensemble des liens vers les réseaux sociaux où l’on peut vous suivre (GitHub, LinkedIn, Twitter…).


        return $this->render("/home/home.php");
    }
}
