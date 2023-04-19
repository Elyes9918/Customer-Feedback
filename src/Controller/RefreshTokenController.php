<?php

namespace App\Controller;

use App\DataTransferObjects\CommentDto;
use App\DataTransferObjects\RefreshTokenDto;
use App\Repository\RefreshTokenRepository;
use App\Services\CommentService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class RefreshTokenController extends AbstractController
{

    public function __construct(
        private RefreshTokenRepository $refreshTokenRepository,
        private ManagerRegistry $doctrine,
        private EntityManagerInterface $entityManager)
    {  

    }


    #[Route('/refreshToken/{email}',name:'app_rt_delete_where_username',methods:"DELETE")]
    public function deleteRefreshToken(string $email):JsonResponse
    {

        $refreshTokens =$this->refreshTokenRepository->findRtsWhereUsername($email);
        $entityManger =$this->doctrine->getManager();

        foreach($refreshTokens as $rt){
            $entityManger->remove($rt);
        }
        $entityManger->flush();
        
        return new JsonResponse([
            'message' => 'refresh Tokens deleted succesfully',
        ], 404);
    }


}