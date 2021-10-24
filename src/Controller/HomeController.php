<?php

namespace App\Controller;

use App\Entity\User;
use App\Core\Route\Route;
use App\Core\Controller\AbstractController;
use App\Core\ORM\ORMReflection;

class HomeController extends AbstractController
{
    #[Route("/")]
    public function home()
    {
        $user = new User();

        $orm = new ORMReflection($user);

        // $orm->buildWhereSQL("email", "test@gmail.com");

        // $test = $user->findBy("name", "Jose");
        // $test = $user->find(7);
        // $test = $user->findAll();
        // $test = $user->delete("id", 10);

        // dd($test);

        // $orm->buildWhereSQL(["email" => [
        //     "test@gmail.com",
        //     "jose@gmail.com",
        //     ],
        //     "id" => 3
        // ]);

        // $orm->setColumnsWithValues("nom", "toto");
        // $orm->setColumnsWithValues("age", 26);

        // dd($orm->getColumnsWithValues());

        $user->setId(11);
        $user->setName("TEST");
        $user->setPrenom("Jose");
        $user->setAge(28);
        // $user->setNomArticle("toto");

        // var_dump($user->getAge());
        
        $user->save();
        // $user->update();

        // dd($orm->getProperties());
        
        // dd($orm->getTable(), $orm->getColumns(), $orm->getValues());





        
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
