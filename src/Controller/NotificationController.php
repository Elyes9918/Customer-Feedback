<?php

namespace App\Controller;

use App\Services\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class NotificationController extends AbstractController
{

    public function __construct(private NotificationService $notificationService)
    {  

    }

    #[Route('/notifications',name:'app_notification_create',methods:"POST")]
    public function createNotification(Request $request):JsonResponse{
        
        $this->notificationService->createNotification($request);

        return new JsonResponse(['messsage' => 'Notification Created successfully'], 201); 
    }



    #[Route('/notifications', name: 'app_notification_get', methods: "GET")]
    public function index(): JsonResponse
    {   
        $notificationDtos = $this->notificationService->listAllNotifications();
       
        return $this->json($notificationDtos);
    }


    #[Route('/notifications/user/{id}', name: 'app_notification_get_byIdUser', methods: "GET")]
    public function getNotificationsByIdUser(string $id): JsonResponse
    {
        $notificationDtos = $this->notificationService->getNotificationsByIdUser($id);
        
        return $this->json($notificationDtos);
    }

    #[Route('/notifications/{id}', name: 'app_notification_patch', methods: "PATCH")]
    public function updateNotification(Request $request,string $id): JsonResponse
    {
        
        if ($id == null) {
            return new JsonResponse("id is incorrect", 200, [], true);
        }
        
        $this->notificationService->updateNotification($request,$id);

        return new JsonResponse(['meesage' => 'Notification updated succesfully'], 201);
    }

    #[Route('/notifications/{id}', name: 'app_notification_delete', methods:"DELETE")]
    public function deleteNotification(string $id): JsonResponse
    {

       $this->notificationService->deleteNotification($id);

        return new JsonResponse([
            'message' => 'Notification deleted succesfully',
        ], 404);
    }

}