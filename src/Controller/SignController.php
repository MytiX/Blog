<?php

namespace App\Controller;

use App\Core\Route\Route;
use App\Core\Controller\AbstractController;
use App\Core\HttpFoundation\Request\Request;
use App\Security\SignUpFormSecurity;

class SignController extends AbstractController
{
    private Request $request;

    public function __construct()
    {
        // $this->request = Request::createFromGlobals();
    }

    #[Route('/signup')]
    public function signUp()
    {
        $form = new SignUpFormSecurity($this->getRequest());

        // dd($this->getRequest());

        // $pseudo = 'DevryX';

        // if (preg_match_all('/[a-z]+/', $pseudo)) {
        //     dd('Ok pseudo');
        // } else {
        //     dd('PAS Ok pseudo');

        // }

        if ($form->isSubmit() && $form->isValid()) {

            $form->getData();
        }
        return $this->render('/sign/signUp.php', [
            'formErrors' => $form->getErrors(),
        ]);
    }

    #[Route('/signin')]
    public function signIn()
    {
        return $this->render('/sign/signIn.php');
    }
}
