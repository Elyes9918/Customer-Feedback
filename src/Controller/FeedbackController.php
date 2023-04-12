<?php

namespace App\Controller;

use App\DataTransferObjects\FeedbackDto;
use App\Services\FeedbackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class FeedbackController extends AbstractController
{

    public function __construct(private FeedbackService $feedbackService)
    {  

    }

    #[Route('/feedbacks',name:'app_feedbacks_create',methods:"POST")]
    public function createFeedback(Request $request):JsonResponse{
        
        $this->feedbackService->createFeedback($request);

        return new JsonResponse(['messsage' => 'Feedback Created successfully'], 201); 
    }



    #[Route('/feedbacks', name: 'app_feedbacks_get', methods: "GET")]
    public function index(): JsonResponse
    {   
        $feedbackDtos = $this->feedbackService->listAllFeedbacks();
       
        return $this->json($feedbackDtos);
    }

    #[Route('/feedbacks/{id}', name: 'app_feedback_get_ById', methods: "GET")]
    public function getFeedbackById(string $id): JsonResponse
    {
        $feedbackDto = new FeedbackDto();
        $feedbackDto = $this->feedbackService->getFeedbackById($id);
        
        return $this->json($feedbackDto);
    }

    #[Route('/feedbacks/user/{id}', name: 'app_feedback_get_byIdUser', methods: "GET")]
    public function getFeedbacksByIdUser(string $id): JsonResponse
    {
        $feedbackDtos = $this->feedbackService->getFeedbackByIdUser($id);
        
        return $this->json($feedbackDtos);
    }

    #[Route('/feedbacks/project/{id}', name: 'app_feedback_get_byIdProject', methods: "GET")]
    public function getFeedbacksByIdProject(string $id): JsonResponse
    {
        $feedbackDtos = $this->feedbackService->getFeedbackByIdProject($id);
        
        return $this->json($feedbackDtos);
    }

    #[Route('/feedbacks/{id}', name: 'app_feedbacks_patch', methods: "PATCH")]
    public function updateFeedback(Request $request,string $id): JsonResponse
    {
        
        if ($id == null) {
            return new JsonResponse("id is incorrect", 200, [], true);
        }
        
        $this->feedbackService->updateFeedback($request,$id);

        return new JsonResponse(['meesage' => 'Feedback updated succesfully'], 201);
    }

    #[Route('/feedbacks/{id}', name: 'app_feedbacks_delete', methods:"DELETE")]
    public function deleteFeedback(string $id): JsonResponse
    {

       $this->feedbackService->deleteFeedback($id);

        return new JsonResponse([
            'message' => 'Feedback deleted succesfully',
        ], 404);
    }

}