<?php

namespace App\Services;

use App\DataTransferObjects\UserDto;
use App\Repository\FeedbackRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class UserService{

    
    public function __construct(
        private UserRepository $userRepository,
        private ManagerRegistry $doctrine,
        private ProjectRepository $projectRepository,
        private FeedbackRepository $feedbackRepository)
        {    
            
        }

    
    public function listAllUsers(): array {

        $users = $this->userRepository->findAll();
        $userDtos = [];

        foreach ($users as $user) {

            $projects = [];
            $feedbacks = [];

            foreach($user->getProjects() as $project){
                // $projects[] = ['id' => $project->getId() ]; //this is an object 
                $projects[] = $project->getId();
            }

            foreach($user->getFeedbacks() as $feedback){
                $feedbacks[] = $feedback->getId() ;
            }

            $userDto = new UserDto();
            $userDto->setId($user->getId());
            $userDto->setEmail($user->getEmail());
            $userDto->setCreatedAt($user->getCreatedAt()->format('Y-m-d H:i:s'));
            $userDto->setModifiedAt($user->getModifiedAt()->format('Y-m-d H:i:s'));
            $userDto->setFirstName($user->getFirstName());
            $userDto->setLastName($user->getLastName());
            $userDto->setBirthDate($user->getBirthDate());
            $userDto->setStatus($user->getStatus());
            $userDto->setAddress($user->getAddress());
            $userDto->setPhoneNumber($user->getPhoneNumber());
            $userDto->setCompany($user->getCompany());
            $userDto->setProjectsId($projects);
            $userDto->setFeedbacksId($feedbacks);
            $userDto->setRoles($user->getRoles());
            $userDto->setIsVerified($user->isVerified());

            $userDtos[] = $userDto;
        }

        return $userDtos;
    }


    public function getUserById(int $id) : UserDto {

        $user = $this->userRepository->find($id);

        $userDto = new UserDto();
        $projects = [];
        $feedbacks = [];

        foreach($user->getProjects() as $project){
            // $projects[] = ['id' => $project->getId() ]; //this is an object 
            $projects[] = $project->getId();
        }
    
    

        foreach($user->getFeedbacks() as $feedback){
            $feedbacks[] = $feedback->getId() ;
        }

        
        $userDto->setId($user->getId());
        $userDto->setEmail($user->getEmail());
        $userDto->setCreatedAt($user->getCreatedAt()->format('Y-m-d H:i:s'));
        $userDto->setModifiedAt($user->getModifiedAt()->format('Y-m-d H:i:s'));
        $userDto->setFirstName($user->getFirstName());
        $userDto->setLastName($user->getLastName());
        $userDto->setBirthDate($user->getBirthDate());
        $userDto->setStatus($user->getStatus());
        $userDto->setAddress($user->getAddress());
        $userDto->setPhoneNumber($user->getPhoneNumber());
        $userDto->setCompany($user->getCompany());
        $userDto->setIsVerified($user->isVerified());
        $userDto->setProjectsId($projects);
        $userDto->setFeedbacksId($feedbacks);
        $userDto->setRoles($user->getRoles());

        return $userDto;
    }

    public function getUserByEmail(string $email) : UserDto {

        $user = $this->userRepository->findOneByEmail($email);

        $userDto = new UserDto();
        $projects = [];
        $feedbacks = [];

        foreach($user->getProjects() as $project){
            // $projects[] = ['id' => $project->getId() ]; //this is an object 
            $projects[] = $project->getId();
        }

        foreach($user->getFeedbacks() as $feedback){
            $feedbacks[] = $feedback->getId() ;
        }

        
        $userDto->setId($user->getId());
        $userDto->setEmail($user->getEmail());
        $userDto->setCreatedAt($user->getCreatedAt()->format('Y-m-d H:i:s'));
        $userDto->setModifiedAt($user->getModifiedAt()->format('Y-m-d H:i:s'));
        $userDto->setFirstName($user->getFirstName());
        $userDto->setLastName($user->getLastName());
        $userDto->setBirthDate($user->getBirthDate());
        $userDto->setStatus($user->getStatus());
        $userDto->setAddress($user->getAddress());
        $userDto->setPhoneNumber($user->getPhoneNumber());
        $userDto->setCompany($user->getCompany());
        $userDto->setProjectsId($projects);
        $userDto->setFeedbacksId($feedbacks);
        $userDto->setRoles($user->getRoles());
        $userDto->setIsVerified($user->isVerified());

        return $userDto;
    }
    

    public function updateUser(Request $request,int $id): void {
       

        $user = $this->userRepository->find($id);


        $data = json_decode($request->getContent(), true);

        if (isset($data['email'])) { $user->setEmail($data['email']);  }

        if (isset($data['firstName'])) { $user->setFirstName($data['firstName']);  }

        if (isset($data['lastName'])) { $user->setLastName($data['lastName']); }

        if (isset($data['birthDate'])) { $user->setBirthDate($data['birthDate']); }

        if (isset($data['status'])) { $user->setStatus($data['status']); }

        if (isset($data['address'])) { $user->setAddress($data['address']); }

        if (isset($data['phoneNumber'])) { $user->setPhoneNumber($data['phoneNumber']); }

        if (isset($data['company'])) { $user->setCompany($data['company']); }

        if (isset($data['projectId'])) { 
            //Logic to assign a single project with an id passed 
            $project = $this->projectRepository->find($data['projectId']);
            $user->addProject($project);
        }

        if (isset($data['feedbackId'])) {
            //Logic to assign a signle feedback with an id passed
            $feedback = $this->feedbackRepository->find($data['feedbackId']);
            $user->addFeedback($feedback);
        }

        if (isset($data['roles'])) { 
            //Logic to a assign multiple roles with the name passed
            $roles = $user->getRoles();
        
            foreach($data['roles'] as $role){
            array_push($roles,$role);
            }

            $user->setRoles($roles); 
        }
    
        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();

    }


    public function unAssignRole(Request $request,int $id): void {

        $user = $this->userRepository->find($id);

        $data = json_decode($request->getContent(), true);

        $roles = $user->getRoles();

        $index = array_search($data['role'],$roles);
        if($index !== FALSE){
            unset($roles[$index]);
        }

        $user->setRoles($roles);

        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();

    }

    public function unAssignProject(Request $request,int $id): void {

        $user = $this->userRepository->find($id);

        $data = json_decode($request->getContent(), true);

        //Logic to remove a project from a user
        //Automatically remove all feedbacks related to that project from this user
        //I have to get all the feedbacks related to the project then unassign them from the user
        
        $feedbacks = $this->feedbackRepository->findBy(array("project"=>$data['projectId']));
        foreach($feedbacks as $feedback){
            $user->removeFeedback($feedback);
        }

        $project = $this->projectRepository->find($data['projectId']);
        $user->removeProject($project);
        


        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();


    }

    public function unAssignFeedBack(Request $request,int $id): void {

        $user = $this->userRepository->find($id);

        $data = json_decode($request->getContent(), true);

        //Logic to remove a feedback from a user
        $feedback = $this->feedbackRepository->find($data['feedbackId']);
        $user->removeFeedback($feedback);

        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();

    }






}
