<?php

namespace App\Services;


use App\DataTransferObjects\NotificationDto;
use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class NotificationService{

    
    public function __construct(
        private ManagerRegistry $doctrine,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private NotificationRepository $notificationRepository,

    ){ 
    }

    public function createNotification(Request $request):void {

        $data = json_decode($request->getContent(), true);

        $usersId = $data['usersId'];
        foreach ($usersId as $userId) {
            $user = $this->userRepository->findOneBy(['token_id' => $userId]);
            if($user->getNotificationIsOn()==1){
                $notification = new Notification();
                $notification->setDescription($data['description']);
                $notification->setIsRead(0);
                $notification->setType($data['type']);
                $notification->setTokenId(md5(uniqid($data['description'], true)));
                $notification->setUser($user);
                $this->entityManager->persist($notification);
            }
        }
            
        $this->entityManager->flush();


    }

    
    public function listAllNotifications(): array {
        $notifications = $this->notificationRepository->findAll();
        $notificationDtos =[];

        foreach($notifications as $notification){
            

            $user=[
                'id' => $notification->getUser()->getTokenId(),
                'name'=>$notification->getUser()->getFirstName() . " " . $notification->getUser()->getLastName()
            ];


            $notificationDto = new NotificationDto();
            $notificationDto->setId($notification->getTokenId());
            $notificationDto->setDescription($notification->getDescription());
            $notificationDto->setIsRead($notification->isIsRead());
            $notificationDto->setType($notification->getType());
            $notificationDto->setCreatedAt($notification->getCreatedAt()->format('Y-m-d H:i:s'));
            $notificationDto->setModifiedAt($notification->getModifiedAt()->format('Y-m-d H:i:s'));
            $notificationDto->setUser($user);

            $notificationDtos[] = $notificationDto;
        }

        return $notificationDtos;

    }


    public function getNotificationsByIdUser(string $id): array {

        $userId= $this->userRepository->findOneBy(['token_id'=>$id])->getId();

        $notifications = $this->notificationRepository->getNotificationsByIdUser($userId);


        $notificationDtos =[];

        foreach($notifications as $notification){
            

            $user=[
                'id' => $notification->getUser()->getTokenId(),
                'name'=>$notification->getUser()->getFirstName() . " " . $notification->getUser()->getLastName()
            ];


            $notificationDto = new NotificationDto();
            $notificationDto->setId($notification->getTokenId());
            $notificationDto->setDescription($notification->getDescription());
            $notificationDto->setIsRead($notification->isIsRead());
            $notificationDto->setType($notification->getType());
            $notificationDto->setCreatedAt($notification->getCreatedAt()->format('Y-m-d H:i:s'));
            $notificationDto->setModifiedAt($notification->getModifiedAt()->format('Y-m-d H:i:s'));
            $notificationDto->setUser($user);

            $notificationDtos[] = $notificationDto;
        }

        return $notificationDtos;

    }

    
    public function updateNotification(Request $request,string $id): void {

        $notification =$this->notificationRepository->findOneBy(['token_id' => $id]);

        $data = json_decode($request->getContent(), true);

        if (isset($data['description'])) { $notification->setDescription($data['description']);}
        if (isset($data['isRead'])) { $notification->setIsRead($data['isRead']);}
           
        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();
    }

    public function deleteNotification(string $id): void {

        $notification =$this->notificationRepository->findOneBy(['token_id' => $id]);
        $entityManger =$this->doctrine->getManager();

        $entityManger->remove($notification);
        $entityManger->flush();

    }


    

}