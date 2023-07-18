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

        $dashboardDto->setFeedbacksStatus($this->feedbackRepository->getFeedbacksStatus());
        $dashboardDto->setProjectsStatus($this->projectRepository->getProjectStatus());
        $dashboardDto->setCompanies($this->projectRepository->getOrderedCompaniesWithTheMostProjects());

        
        return $dashboardDto;


    }



}