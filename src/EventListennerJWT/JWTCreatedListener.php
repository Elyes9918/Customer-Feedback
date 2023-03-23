<?php

namespace App\EventListennerJWT;

// src/App/EventListener/JWTCreatedListener.php

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{

    public function __construct(private UserRepository $userRepository,private ManagerRegistry $doctrine,
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

        $user->setLastLogin(new DateTime());

        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();

  
    }

}