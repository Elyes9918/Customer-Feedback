<?php

namespace App\Services;

use App\DataTransferObjects\DashboardDto;
use App\Repository\CommentRepository;
use App\Repository\FeedbackRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DashboardService{

    public function __construct(
        private ManagerRegistry $doctrine,
        private EntityManagerInterface $entityManager,
        private FeedbackRepository $feedbackRepository,
        private UserRepository $userRepository,
        private CommentRepository $commentRepository,
        private ProjectRepository $projectRepository
    ){ 
    }



    public function dashboardData() : DashboardDto {

        $dashboardDto = new DashboardDto();

        $dashboardDto->setUsers($this->userRepository->getUsersCount());
        $dashboardDto->setActiveUsers($this->userRepository->getValidatedUsersCount());

        $dashboardDto->setProjects($this->projectRepository->getProjectsCount());
        $dashboardDto->setCompletedProjects($this->projectRepository->getCompletedProjectsCount());

        $dashboardDto->setAdminUsers($this->userRepository->getAdminUsersCount());
        $dashboardDto->setGestionaireUsers($this->userRepository->getGestionnaireUsersCount());
        $dashboardDto->setMemberUsers($this->userRepository->getMemberUsersCount());
        $dashboardDto->setClientUsers($this->userRepository->getClientUsersCount());

        $dashboardDto->setTickets($this->feedbackRepository->getTotalfeedbacksCount());
        $dashboardDto->setAverageTicketsPerProject($this->feedbackRepository->getAverageFeedbacksCountPerProject());

        // $projectStatus= [];

        // $projectStatus[]=[
        //     'completedProjects'=> 2,
        //     'waitingProjects'=> 2,
        //     'closedProjects'=> 2,
        // ];

        $dashboardDto->setProjectsStatus($this->projectRepository->getProjectStatus());
        
        return $dashboardDto;


        // $project = $this->projectRepository->findOneBy(['token_id'=>$id]);

        // $projectDto = new ProjectDto();

        // $users = [];
        // $feedbacks = [];


        // foreach($project->getUsers() as $user){
        //     $users[] = [
        //         'id' => $user->getTokenId(),
        //         'name' => $user->getFirstName() . " " . $user->getLastName(),
        //         'roles' => $user->getRoles(),
        //       ];
        // }

        // foreach($project->getFeedbacks() as $feedback){
        //     $feedbacks[] = [
        //         'id' => $feedback->getTokenId(),
        //         'status' => $feedback->getStatus()
        //       ];
        // }

        // $creator=[
        //     'id' => $project->getCreator()->getTokenId(),
        //     'name'=>$project->getCreator()->getFirstName() . " " . $project->getCreator()->getLastName(),
        //     'roles' =>$project->getCreator()->getRoles(),  
        // ];

        // $projectDto = new ProjectDto();
        // $projectDto->setId($project->getTokenId());
        // $projectDto->setTitle($project->getTitle());
        // $projectDto->setClient($project->getClient());
        // $projectDto->setStatus($project->getStatus());
        // $projectDto->setDescription($project->getDescription());
        // $projectDto->setRepo($project->getRepo());
        // $projectDto->setCreatedAt($project->getCreatedAt()->format('Y-m-d H:i:s'));
        // $projectDto->setModifiedAt($project->getModifiedAt()->format('Y-m-d H:i:s'));
        // $projectDto->setUsersId($users);
        // $projectDto->setCreator($creator);
        // $projectDto->setFeedbacks($feedbacks);


        // return $projectDto;

    }



}