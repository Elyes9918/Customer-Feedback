<?php

namespace App\Services;

use App\DataTransferObjects\FeedbackDto;
use App\Entity\Feedback;
use App\Repository\FeedbackRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class FeedbackService{

    
    public function __construct(
        private ManagerRegistry $doctrine,
        private FeedbackRepository $feedbackRepository,
        private ProjectRepository $projectRepository,
        private EntityManagerInterface $entityManager,
    ){ 

    }

    public function createFeedback(Request $request):void {

        $feedback = new Feedback();
        $data = json_decode($request->getContent(), true);


        $feedback->setSujet($data['sujet']);
        $feedback->setDescription($data['description']);

        $project = $this->projectRepository->findOneBy(['token_id'=>$data['project_id']]);
        $feedback->setProject($project);

        $feedback->setPriority($data['priority']);
        $feedback->setStatus(Feedback::STATUS_ONHOLD);
        $feedback->setRealised(Feedback::REALSIED_NOTYET);
        $feedback->setEstimatedTime(0);
        $feedback->setRating(0);

        

        $feedback->setTokenId(md5(uniqid($data['sujet'], true)));


        $this->entityManager->persist($feedback);
        $this->entityManager->flush();

    }

    
    public function listAllFeedbacks(): array {
        $feedbacks = $this->feedbackRepository->findAll();
        $feedbackDtos =[];

        foreach($feedbacks as $feedback){
            $users = [];

            foreach($feedback->getUsers() as $user){
                $users[] = $user->getTokenId();
            }

            $feedbackDto = new FeedbackDto();
            $feedbackDto->setId($feedback->getTokenId());
            $feedbackDto->setSujet($feedback->getSujet());
            $feedbackDto->setDescription($feedback->getDescription());
            $feedbackDto->setProjectId($feedback->getProject()->getTokenId());
            $feedbackDto->setStatus($feedback->getStatus());
            $feedbackDto->setRealised($feedback->getRealised());
            $feedbackDto->setEstimatedTime($feedback->getEstimatedTime());
            $feedbackDto->setPriority($feedback->getPriority());
            $feedbackDto->setRating($feedback->getRating());
            $feedbackDto->setCreatedAt($feedback->getCreatedAt()->format('Y-m-d H:i:s'));
            $feedbackDto->setModifiedAt($feedback->getModifiedAt()->format('Y-m-d H:i:s'));
            $feedbackDto->setUsersId($users);


            $feedbackDtos[] = $feedbackDto;
        }

        return $feedbackDtos;

    }

    public function getFeedbackById(string $id) : FeedbackDto {
        $feedback = $this->feedbackRepository->findOneBy(['token_id'=>$id]);

        $feedbackDto = new FeedbackDto();

        $users = [];

        foreach($feedback->getUsers() as $user){
            $users[] = $user->getTokenId();
        }

        $feedbackDto = new FeedbackDto();
        $feedbackDto->setId($feedback->getTokenId());
        $feedbackDto->setSujet($feedback->getSujet());
        $feedbackDto->setDescription($feedback->getDescription());
        $feedbackDto->setProjectId($feedback->getProject()->getTokenId());
        $feedbackDto->setStatus($feedback->getStatus());
        $feedbackDto->setRealised($feedback->getRealised());
        $feedbackDto->setEstimatedTime($feedback->getEstimatedTime());
        $feedbackDto->setPriority($feedback->getPriority());
        $feedbackDto->setRating($feedback->getRating());
        $feedbackDto->setCreatedAt($feedback->getCreatedAt()->format('Y-m-d H:i:s'));
        $feedbackDto->setModifiedAt($feedback->getModifiedAt()->format('Y-m-d H:i:s'));
        $feedbackDto->setUsersId($users);


        return $feedbackDto;

        
    }

    public function updateFeedback(Request $request,string $id): void {

        $feedback =$this->feedbackRepository->findOneBy(['token_id' => $id]);

        $data = json_decode($request->getContent(), true);

        if (isset($data['sujet'])) { $feedback->setSujet($data['sujet']);}
        if (isset($data['description'])) { $feedback->setDescription($data['description']);}

        if (isset($data['project_id'])) { 
            $project = $this->projectRepository->findOneB(['token_id'=>$data['project_id']]);
            $feedback->setProject($project);
        }

        if (isset($data['status'])) { $feedback->setStatus($data['status']);}
        if (isset($data['priority'])) { $feedback->setPriority($data['priority']);}
        if (isset($data['realised'])) { $feedback->setRealised($data['realised']);}
        if (isset($data['estimated_time'])) { $feedback->setEstimatedTime($data['estimated_time']);}
        if (isset($data['rating'])) { $feedback->setRating($data['rating']);}
    
        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();


    }

    public function deleteFeedback(string $id): void {

        $feedback =$this->feedbackRepository->findOneBy(['token_id' => $id]);
        $entityManger =$this->doctrine->getManager();

        $historiques = $feedback->getHistoriques();

        foreach($historiques as $historique){
            $entityManger->remove($historique);
        }

        $entityManger->remove($feedback);
        $entityManger->flush();

    }


    

}