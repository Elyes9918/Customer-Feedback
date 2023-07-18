<?php 

namespace App\DataTransferObjects;

class DashboardDto {


    private ?string $users=null;
    private ?string $activeUsers=null;
    private ?String $projects=null;
    private ?String $completedProjects=null;
    private ?String $adminUsers = null;
    private ?String $gestionaireUsers = null;
    private ?String $memberUsers = null;
    private ?String $clientUsers = null;
    private ?string $averageTicketsPerProject = null;
    private ?string $tickets = null;
    private array   $projectsStatus=[];
    private array   $feedbacksStatus=[];
    private array   $companies=[];


    /**
     * Get the value of users
     */
    public function getUsers(): ?string
    {
        return $this->users;
    }

    /**
     * Set the value of users
     */
    public function setUsers(?string $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get the value of activeUsers
     */
    public function getActiveUsers(): ?string
    {
        return $this->activeUsers;
    }

    /**
     * Set the value of activeUsers
     */
    public function setActiveUsers(?string $activeUsers): self
    {
        $this->activeUsers = $activeUsers;

        return $this;
    }

    /**
     * Get the value of projects
     */
    public function getProjects(): ?String
    {
        return $this->projects;
    }

    /**
     * Set the value of projects
     */
    public function setProjects(?String $projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    /**
     * Get the value of completedProjects
     */
    public function getCompletedProjects(): ?String
    {
        return $this->completedProjects;
    }

    /**
     * Set the value of completedProjects
     */
    public function setCompletedProjects(?String $completedProjects): self
    {
        $this->completedProjects = $completedProjects;

        return $this;
    }

    /**
     * Get the value of adminUsers
     */
    public function getAdminUsers(): ?String
    {
        return $this->adminUsers;
    }

    /**
     * Set the value of adminUsers
     */
    public function setAdminUsers(?String $adminUsers): self
    {
        $this->adminUsers = $adminUsers;

        return $this;
    }

    /**
     * Get the value of gestionaireUsers
     */
    public function getGestionaireUsers(): ?String
    {
        return $this->gestionaireUsers;
    }

    /**
     * Set the value of gestionaireUsers
     */
    public function setGestionaireUsers(?String $gestionaireUsers): self
    {
        $this->gestionaireUsers = $gestionaireUsers;

        return $this;
    }

    /**
     * Get the value of memberUsers
     */
    public function getMemberUsers(): ?String
    {
        return $this->memberUsers;
    }

    /**
     * Set the value of memberUsers
     */
    public function setMemberUsers(?String $memberUsers): self
    {
        $this->memberUsers = $memberUsers;

        return $this;
    }

    /**
     * Get the value of clientUsers
     */
    public function getClientUsers(): ?String
    {
        return $this->clientUsers;
    }

    /**
     * Set the value of clientUsers
     */
    public function setClientUsers(?String $clientUsers): self
    {
        $this->clientUsers = $clientUsers;

        return $this;
    }

    /**
     * Get the value of averageTicketsPerProject
     */
    public function getAverageTicketsPerProject(): ?string
    {
        return $this->averageTicketsPerProject;
    }

    /**
     * Set the value of averageTicketsPerProject
     */
    public function setAverageTicketsPerProject(?string $averageTicketsPerProject): self
    {
        $this->averageTicketsPerProject = $averageTicketsPerProject;

        return $this;
    }

    /**
     * Get the value of tickets
     */
    public function getTickets(): ?string
    {
        return $this->tickets;
    }

    /**
     * Set the value of tickets
     */
    public function setTickets(?string $tickets): self
    {
        $this->tickets = $tickets;

        return $this;
    }

  

    /**
     * Get the value of projectsStatus
     */
    public function getProjectsStatus(): array
    {
        return $this->projectsStatus;
    }

    /**
     * Set the value of projectsStatus
     */
    public function setProjectsStatus(array $projectsStatus): self
    {
        $this->projectsStatus = $projectsStatus;

        return $this;
    }

    /**
     * Get the value of companies
     */
    public function getCompanies(): array
    {
        return $this->companies;
    }

    /**
     * Set the value of companies
     */
    public function setCompanies(array $companies): self
    {
        $this->companies = $companies;

        return $this;
    }

    /**
     * Get the value of feedbacksStatus
     */
    public function getFeedbacksStatus(): array
    {
        return $this->feedbacksStatus;
    }

    /**
     * Set the value of feedbacksStatus
     */
    public function setFeedbacksStatus(array $feedbacksStatus): self
    {
        $this->feedbacksStatus = $feedbacksStatus;

        return $this;
    }
}