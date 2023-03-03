<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin',methods:"GET")]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");


        /** @var User $user */
        $user = $this->getUser();

        return match ($user->isVerified()){
            true =>  $this->json([
                'message' => "User authenticated succesfully",
            ]),
            false =>  $this->json([
                'message' => "Please verify Email",
            ]),
        };

    }
}
