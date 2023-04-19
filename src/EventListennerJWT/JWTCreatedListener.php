<?php

namespace App\EventListennerJWT;

// src/App/EventListener/JWTCreatedListener.php

use App\Repository\RefreshTokenRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{

    public function __construct(private UserRepository $userRepository,private ManagerRegistry $doctrine,
    private RefreshTokenRepository $refreshTokenRepository,
    )
    {
    }
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {

        $payload = $event->getData();
        $user = $this->userRepository->findOneBy(['email' =>$payload['username']]);
        $payload['isVerified'] = $user->isVerified();
        $payload['id']=$user->getTokenId();
        $event->setData($payload);

        $header        = $event->getHeader();
        $header['cty'] = 'JWT';

        $event->setHeader($header);

        // this deletes the previous refresh tokens each time a user login in 
        $refreshTokens =$this->refreshTokenRepository->findRtsWhereUsername($user->getEmail());
        $entityManger =$this->doctrine->getManager();

        foreach($refreshTokens as $rt){
            $entityManger->remove($rt);
        }
        $entityManger->flush();

        

        $user->setLastLogin(new DateTime());

        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();

  
    }

}