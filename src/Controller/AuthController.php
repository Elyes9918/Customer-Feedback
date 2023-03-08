<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class AuthController extends AbstractController {

    // #[Route('/login', name: 'api_UserLogin', methods:"GET")]
    // public function login(Request $request): Response
    // {



    //     return $this->json([
    //         'User'  => 'Hi',
    //     ]);
    // }

}