<?php

namespace App\Services;

use App\DataTransferObjects\FeedbackDto;
use App\Entity\Feedback;
use App\Repository\FeedbackRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class FeedbackService{

    
    public function __construct(
        private ManagerRegistry $doctrine,
        private FeedbackRepository $feedbackRepository,
        private ProjectRepository $projectRepository,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    ){ 

    }

    public function createFeedback(Request $request):void {

        $feedback = new Feedback();
        $data = json_decode($request->getContent(), true);


        $feedback->setTitle($data['title']);
        $feedback->setDescription($data['description']);

        $project = $this->projectRepository->findOneBy(['token_id'=>$data['project_id']]);
        $feedback->setProject($project);

        $creatorId = $data['creatorId'];
        $creator = $this->userRepository->findOneBy(['token_id' => $creatorId]);
        $feedback->setCreator($creator);

        if(isset ($data['usersId'])){
             $usersId = $data['usersId'];
        foreach ($usersId as $userId) {
            $user =  $this->userRepository->findOneBy(['token_id' => $userId]);
            $feedback->addUser($user);
          }
        }
       

        $feedback->setPriority($data['priority']);
        $feedback->setStatus($data['status']);
        $feedback->setEstimatedTime(0);
        $feedback->setRating(0);
        $feedback->setProgress(0);
        
        $feedback->setTokenId(md5(uniqid($data['title'], true)));

        $this->entityManager->persist($feedback);
        $this->entityManager->flush();

    }

    
    public function listAllFeedbacks(): array {
        $feedbacks = $this->feedbackRepository->findAll();
        $feedbackDtos =[];

        foreach($feedbacks as $feedback){
            $users = [];

            foreach($feedback->getUsers() as $user){
                $users[] = [
                    'id' => $user->getTokenId(),
                    'name' => $user->getFirstName() . " " . $user->getLastName(),
                    'roles' => $user->getRoles(),
                  ];
            }

            $creator=[
                'id' => $feedback->getCreator()->getTokenId(),
                'name'=>$feedback->getCreator()->getFirstName() . " " . $feedback->getCreator()->getLastName(),
                'roles' =>$feedback->getCreator()->getRoles(),  
            ];

            $feedbackDto = new FeedbackDto();
            $feedbackDto->setId($feedback->getTokenId());
            $feedbackDto->setTitle($feedback->getTitle());
            $feedbackDto->setDescription($feedback->getDescription());
            $feedbackDto->setProjectId($feedback->getProject()->getTokenId());
            $feedbackDto->setStatus($feedback->getStatus());
            $feedbackDto->setEstimatedTime($feedback->getEstimatedTime());
            $feedbackDto->setPriority($feedback->getPriority());
            $feedbackDto->setRating($feedback->getRating());
            $feedbackDto->setProgress($feedback->getProgress());
            $feedbackDto->setRepo($feedback->getProject()->getRepo());
            $feedbackDto->setCreatedAt($feedback->getCreatedAt()->format('Y-m-d H:i:s'));
            $feedbackDto->setModifiedAt($feedback->getModifiedAt()->format('Y-m-d H:i:s'));
            $feedbackDto->setUsersId($users);
            $feedbackDto->setCreator($creator);



            $feedbackDtos[] = $feedbackDto;
        }

        return $feedbackDtos;

    }

    public function getFeedbackById(string $id) : FeedbackDto {
        $feedback = $this->feedbackRepository->findOneBy(['token_id'=>$id]);

        $feedbackDto = new FeedbackDto();

        $users = [];

        foreach($feedback->getUsers() as $user){
            $users[] = [
                'id' => $user->getTokenId(),
                'name' => $user->getFirstName() . " " . $user->getLastName(),
                'roles' => $user->getRoles(),
              ];
        }

        $creator=[
            'id' => $feedback->getCreator()->getTokenId(),
            'name'=>$feedback->getCreator()->getFirstName() . " " . $feedback->getCreator()->getLastName(),
            'roles' =>$feedback->getCreator()->getRoles(),  
        ];

        $project=[
            'id'=> $feedback->getProject()->getTokenId(),
            "name"=>$feedback->getProject()->getTitle(),
            "client"=>$feedback->getProject()->getClient()
        ];

        $feedbackDto = new FeedbackDto();
        $feedbackDto->setId($feedback->getTokenId());
        $feedbackDto->setTitle($feedback->getTitle());
        $feedbackDto->setDescription($feedback->getDescription());
        $feedbackDto->setStatus($feedback->getStatus());
        $feedbackDto->setEstimatedTime($feedback->getEstimatedTime());
        $feedbackDto->setPriority($feedback->getPriority());
        $feedbackDto->setRating($feedback->getRating());
        $feedbackDto->setProgress($feedback->getProgress());
        $feedbackDto->setRepo($feedback->getProject()->getRepo());
        $feedbackDto->setCreatedAt($feedback->getCreatedAt()->format('Y-m-d H:i:s'));
        $feedbackDto->setModifiedAt($feedback->getModifiedAt()->format('Y-m-d H:i:s'));
        $feedbackDto->setUsersId($users);
        $feedbackDto->setCreator($creator);
        $feedbackDto->setProject($project);

        return $feedbackDto;
    }

    public function getFeedbackByIdProject(string $id): array {

        $projectId= $this->projectRepository->findOneBy(['token_id'=>$id])->getId();

        $feedbacks = $this->feedbackRepository->getAllFeedbacksByIdProject($projectId);
        $feedbackDtos =[];

        foreach($feedbacks as $feedback){
            $users = [];

            foreach($feedback->getUsers() as $user){
                $users[] = [
                    'id' => $user->getTokenId(),
                    'name' => $user->getFirstName() . " " . $user->getLastName(),
                    'roles' => $user->getRoles(),
                  ];
            }

            $creator=[
                'id' => $feedback->getCreator()->getTokenId(),
                'name'=>$feedback->getCreator()->getFirstName() . " " . $feedback->getCreator()->getLastName(),
                'roles' =>$feedback->getCreator()->getRoles(),  
            ];

            $feedbackDto = new FeedbackDto();
            $feedbackDto->setId($feedback->getTokenId());
            $feedbackDto->setTitle($feedback->getTitle());
            $feedbackDto->setDescription($feedback->getDescription());
            $feedbackDto->setProjectId($feedback->getProject()->getTokenId());
            $feedbackDto->setStatus($feedback->getStatus());
            $feedbackDto->setEstimatedTime($feedback->getEstimatedTime());
            $feedbackDto->setPriority($feedback->getPriority());
            $feedbackDto->setRating($feedback->getRating());
            $feedbackDto->setProgress($feedback->getProgress());
            $feedbackDto->setRepo($feedback->getProject()->getRepo());
            $feedbackDto->setCreatedAt($feedback->getCreatedAt()->format('Y-m-d H:i:s'));
            $feedbackDto->setModifiedAt($feedback->getModifiedAt()->format('Y-m-d H:i:s'));
            $feedbackDto->setUsersId($users);
            $feedbackDto->setCreator($creator);

            $feedbackDtos[] = $feedbackDto;
        }

        return $feedbackDtos;

    }

    public function getFeedbackByIdUser(string $id): array {
        $feedbacks = $this->feedbackRepository->getAllFeedbacksByIdUser($id);
        $feedbackDtos =[];

        foreach($feedbacks as $feedback){
            $users = [];

            foreach($feedback->getUsers() as $user){
                $users[] = [
                    'id' => $user->getTokenId(),
                    'name' => $user->getFirstName() . " " . $user->getLastName(),
                    'roles' => $user->getRoles(),
                  ];
            }

            $creator=[
                'id' => $feedback->getCreator()->getTokenId(),
                'name'=>$feedback->getCreator()->getFirstName() . " " . $feedback->getCreator()->getLastName(),
                'roles' =>$feedback->getCreator()->getRoles(),  
            ];

            $feedbackDto = new FeedbackDto();
            $feedbackDto->setId($feedback->getTokenId());
            $feedbackDto->setTitle($feedback->getTitle());
            $feedbackDto->setDescription($feedback->getDescription());
            $feedbackDto->setProjectId($feedback->getProject()->getTokenId());
            $feedbackDto->setStatus($feedback->getStatus());
            $feedbackDto->setEstimatedTime($feedback->getEstimatedTime());
            $feedbackDto->setPriority($feedback->getPriority());
            $feedbackDto->setRating($feedback->getRating());
            $feedbackDto->setProgress($feedback->getProgress());
            $feedbackDto->setRepo($feedback->getProject()->getRepo());
            $feedbackDto->setCreatedAt($feedback->getCreatedAt()->format('Y-m-d H:i:s'));
            $feedbackDto->setModifiedAt($feedback->getModifiedAt()->format('Y-m-d H:i:s'));
            $feedbackDto->setUsersId($users);
            $feedbackDto->setCreator($creator);

            $feedbackDtos[] = $feedbackDto;
        }

        return $feedbackDtos;

    }

    public function updateFeedback(Request $request,string $id): void {

        $feedback =$this->feedbackRepository->findOneBy(['token_id' => $id]);

        $data = json_decode($request->getContent(), true);

        if (isset($data['title'])) { $feedback->setTitle($data['title']);}
        if (isset($data['description'])) { $feedback->setDescription($data['description']);}

        if (isset($data['project_id'])) { 
            $project = $this->projectRepository->findOneBy(['token_id'=>$data['project_id']]);
            $feedback->setProject($project);
        }

        if (isset($data['status'])) { $feedback->setStatus($data['status']);}
        if (isset($data['priority'])) { $feedback->setPriority($data['priority']);}
        if (isset($data['estimatedTime'])) { $feedback->setEstimatedTime($data['estimatedTime']);}
        if (isset($data['rating'])) { $feedback->setRating($data['rating']);}
        if(isset($data['progress'])){$feedback->setProgress($data['progress']);}

        if (isset($data['usersId'])){

            $usersId = $data['usersId'];
            
            foreach($feedback->getUsers() as $user){
                $feedback->removeUser($user);
            }

            foreach ($usersId as $userId) {
                $user =  $this->userRepository->findOneBy(['token_id' => $userId]);
                $feedback->addUser($user);
            }
        }
    
        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();
    }

    public function deleteFeedback(string $id): void {

        $feedback =$this->feedbackRepository->findOneBy(['token_id' => $id]);
        $entityManger =$this->doctrine->getManager();

        $comments = $feedback->getComments();

        foreach($comments as $comment){
            $entityManger->remove($comment);
        }

        $entityManger->remove($feedback);
        $entityManger->flush();

    }


    

}