<?php

namespace App\Services;

use App\DataTransferObjects\CommentDto;
use App\DataTransferObjects\FeedbackDto;
use App\Entity\Comment;
use App\Entity\Feedback;
use App\Repository\CommentRepository;
use App\Repository\FeedbackRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class CommentService{

    
    public function __construct(
        private ManagerRegistry $doctrine,
        private FeedbackRepository $feedbackRepository,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private CommentRepository $commentRepository
    ){ 
    }

    public function createComment(Request $request):void {

        $comment = new Comment();
        $data = json_decode($request->getContent(), true);

        $comment->setDescription($data['description']);
        $comment->setType(intval($data['type']));

        $userId = $data['userId'];
        $comment->setUser($this->userRepository->findOneBy(['token_id' => $userId]));

        $feedbackId = $data['feedbackId'];
        $comment->setFeedback($this->feedbackRepository->findOneBy(['token_id' => $feedbackId]));
    
        $comment->setTokenId(md5(uniqid($data['description'], true)));

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

    }

    
    public function listAllComments(): array {
        $comments = $this->commentRepository->findAll();
        $commentDtos =[];

        foreach($comments as $comment){
            

            $user=[
                'id' => $comment->getUser()->getTokenId(),
                'name'=>$comment->getUser()->getFirstName() . " " . $comment->getUser()->getLastName()
            ];

            $feedback=[
                'id' => $comment->getFeedback()->getTokenId(),
            ];

            $commentDto = new CommentDto();
            $commentDto->setId($comment->getTokenId());
            $commentDto->setDescription($comment->getDescription());
            $commentDto->setType($comment->getType());
            $commentDto->setCreatedAt($comment->getCreatedAt()->format('Y-m-d H:i:s'));
            $commentDto->setModifiedAt($comment->getModifiedAt()->format('Y-m-d H:i:s'));
            $commentDto->setUser($user);
            $commentDto->setFeedback($feedback);

            $commentDtos[] = $commentDto;
        }

        return $commentDtos;

    }

    public function getCommentById(string $id) : CommentDto {
        $comment = $this->commentRepository->findOneBy(['token_id'=>$id]);

        $commentDto = new CommentDto();
        
        $user=[
            'id' => $comment->getUser()->getTokenId(),
            'name'=>$comment->getUser()->getFirstName() . " " . $comment->getUser()->getLastName()
        ];

        $feedback=[
            'id' => $comment->getFeedback()->getTokenId(),
        ];

        $commentDto->setId($comment->getTokenId());
        $commentDto->setDescription($comment->getDescription());
        $commentDto->setType($comment->getType());
        $commentDto->setCreatedAt($comment->getCreatedAt()->format('Y-m-d H:i:s'));
        $commentDto->setModifiedAt($comment->getModifiedAt()->format('Y-m-d H:i:s'));
        $commentDto->setUser($user);
        $commentDto->setFeedback($feedback);

        return $commentDto;
    }

    public function getCommentByIdFeedback(string $id): array {

        $FeedbackId= $this->feedbackRepository->findOneBy(['token_id'=>$id])->getId();

        $comments = $this->commentRepository->getAllCommentsByIdFeedback($FeedbackId);
        $commentDtos =[];

        foreach($comments as $comment){
            $user=[
                'id' => $comment->getUser()->getTokenId(),
                'name'=>$comment->getUser()->getFirstName() . " " . $comment->getUser()->getLastName()
            ];

            $feedback=[
                'id' => $comment->getFeedback()->getTokenId(),
            ];

            $commentDto = new CommentDto();
            $commentDto->setId($comment->getTokenId());
            $commentDto->setDescription($comment->getDescription());
            $commentDto->setType($comment->getType());
            $commentDto->setCreatedAt($comment->getCreatedAt()->format('Y-m-d H:i:s'));
            $commentDto->setModifiedAt($comment->getModifiedAt()->format('Y-m-d H:i:s'));
            $commentDto->setUser($user);
            $commentDto->setFeedback($feedback);

            $commentDtos[] = $commentDto;
        }

        return $commentDtos;

    }

    
    public function updateComment(Request $request,string $id): void {

        $comment =$this->commentRepository->findOneBy(['token_id' => $id]);

        $data = json_decode($request->getContent(), true);

        if (isset($data['description'])) { $comment->setDescription($data['description']);}
        if (isset($data['type'])) { $comment->setType(intval($data['type']));}
           
        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();
    }

    public function deleteComment(string $id): void {

        $comment =$this->commentRepository->findOneBy(['token_id' => $id]);
        $entityManger =$this->doctrine->getManager();

        $entityManger->remove($comment);
        $entityManger->flush();

    }


    

}