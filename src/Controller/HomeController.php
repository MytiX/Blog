<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\HttpFoundation\Response\Response;
use App\Core\ORM\ActiveRecord;
use App\Core\PDO\ConnectionDB;
use App\Core\Templating\Templating;
use App\Entity\User;

class HomeController extends AbstractController
{
    public function __invoke()
    {
        $user = new User();

        $entityManager = new ActiveRecord();

        $entityManager->findById(1, $user);



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
