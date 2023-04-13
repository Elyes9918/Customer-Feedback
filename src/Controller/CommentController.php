<?php

namespace App\Controller;

use App\DataTransferObjects\CommentDto;
use App\Services\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class CommentController extends AbstractController
{

    public function __construct(private CommentService $commentService)
    {  

    }

    #[Route('/comments',name:'app_comments_create',methods:"POST")]
    public function createComment(Request $request):JsonResponse{
        
        $this->commentService->createComment($request);

        return new JsonResponse(['messsage' => 'Comment Created successfully'], 201); 
    }



    #[Route('/comments', name: 'app_comments_get', methods: "GET")]
    public function index(): JsonResponse
    {   
        $commentDtos = $this->commentService->listAllComments();
       
        return $this->json($commentDtos);
    }

    #[Route('/comments/{id}', name: 'app_comment_get_ById', methods: "GET")]
    public function getCommentById(string $id): JsonResponse
    {
        $commentDto = new CommentDto();
        $commentDto = $this->commentService->getCommentById($id);
        
        return $this->json($commentDto);
    }


    #[Route('/comments/feedback/{id}', name: 'app_comment_get_byIdComment', methods: "GET")]
    public function getCommentsByIdFeedback(string $id): JsonResponse
    {
        $commentDtos = $this->commentService->getCommentByIdFeedback($id);
        
        return $this->json($commentDtos);
    }

    #[Route('/comments/{id}', name: 'app_comments_patch', methods: "PATCH")]
    public function updateComment(Request $request,string $id): JsonResponse
    {
        
        if ($id == null) {
            return new JsonResponse("id is incorrect", 200, [], true);
        }
        
        $this->commentService->updateComment($request,$id);

        return new JsonResponse(['meesage' => 'Comment updated succesfully'], 201);
    }

    #[Route('/comments/{id}', name: 'app_comments_delete', methods:"DELETE")]
    public function deleteComment(string $id): JsonResponse
    {

       $this->commentService->deleteComment($id);

        return new JsonResponse([
            'message' => 'Comment deleted succesfully',
        ], 404);
    }

}