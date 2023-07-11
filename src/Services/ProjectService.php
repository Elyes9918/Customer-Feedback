<?php

namespace App\Services;

use App\DataTransferObjects\ProjectDto;
use App\Entity\Project;
use App\Repository\FeedbackRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ProjectService{

    public function __construct(
        private ManagerRegistry $doctrine,
        private ProjectRepository $projectRepository,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private FeedbackRepository $feedbackRepository
    ){ 

    }

    public function createProject(Request $request):void {
        $project = new Project();
        $data = json_decode($request->getContent(), true);

        $project->setTitle($data['title']);
        $project->setClient($data['client']);
        $project->setDescription($data['description']);
        $project->setRepo($data['repo']);

        $creatorId = $data['creatorId'];
        $creator = $this->userRepository->findOneBy(['token_id' => $creatorId]);
        $project->setCreator($creator);

        // I will get an array of user id I want to add these users to my project
        
        $usersId = $data['usersId'];
        foreach ($usersId as $userId) {
            $user =  $this->userRepository->findOneBy(['token_id' => $userId]);
            $project->addUser($user);
          }



        $project->setStatus(1);
        $project->setTokenId(md5(uniqid($data['title'], true)));


        $this->entityManager->persist($project);
        $this->entityManager->flush();

    }

    
    public function listAllProjects(): array {
        $projects = $this->projectRepository->findAll();
        $projectDtos =[];

        foreach($projects as $project){
            $users = [];
            $feedbacks = [];


            foreach($project->getUsers() as $user){
                $users[] = [
                    'id' => $user->getTokenId(),
                    'name' => $user->getFirstName() . " " . $user->getLastName(),
                    'roles' => $user->getRoles(),
                  ];
            }

            
            foreach($project->getFeedbacks() as $feedback){
                $feedbacks[] = [
                    'id' => $feedback->getTokenId(),
                    'status' => $feedback->getStatus()
                  ];
            }

            
            $creator=[
                'id' => $project->getCreator()->getTokenId(),
                'name'=>$project->getCreator()->getFirstName() . " " . $project->getCreator()->getLastName(),
                'roles' =>$project->getCreator()->getRoles(),  
            ];


            $projectDto = new ProjectDto();
            $projectDto->setId($project->getTokenId());
            $projectDto->setTitle($project->getTitle());
            $projectDto->setClient($project->getClient());
            $projectDto->setStatus($project->getStatus());
            $projectDto->setDescription($project->getDescription());
            $projectDto->setRepo($project->getRepo());
            $projectDto->setCreatedAt($project->getCreatedAt()->format('Y-m-d H:i:s'));
            $projectDto->setModifiedAt($project->getModifiedAt()->format('Y-m-d H:i:s'));
            $projectDto->setUsersId($users);
            $projectDto->setCreator($creator);
            $projectDto->setFeedbacks($feedbacks);


            $projectDtos[] = $projectDto;
        }

        return $projectDtos;

    }

    public function getProjectsByIdPersonne(string $id): array {
        $projects = $this->projectRepository->getAllProjectsByIdUser($id);
        $projectDtos =[];

        foreach($projects as $project){
            $users = [];
            $feedbacks = [];


            foreach($project->getUsers() as $user){
                $users[] = [
                    'id' => $user->getTokenId(),
                    'name' => $user->getFirstName() . " " . $user->getLastName(),
                    'roles' => $user->getRoles(),
                  ];
            }

            foreach($project->getFeedbacks() as $feedback){
                $feedbacks[] = [
                    'id' => $feedback->getTokenId(),
                    'status' => $feedback->getStatus()
                  ];
            }

            $creator=[
                'id' => $project->getCreator()->getTokenId(),
                'name'=>$project->getCreator()->getFirstName() . " " . $project->getCreator()->getLastName(),
                'roles' =>$project->getCreator()->getRoles(),  
            ];

            $projectDto = new ProjectDto();
            $projectDto->setId($project->getTokenId());
            $projectDto->setTitle($project->getTitle());
            $projectDto->setClient($project->getClient());
            $projectDto->setStatus($project->getStatus());
            $projectDto->setDescription($project->getDescription());
            $projectDto->setRepo($project->getRepo());
            $projectDto->setCreatedAt($project->getCreatedAt()->format('Y-m-d H:i:s'));
            $projectDto->setModifiedAt($project->getModifiedAt()->format('Y-m-d H:i:s'));
            $projectDto->setUsersId($users);
            $projectDto->setCreator($creator);
            $projectDto->setFeedbacks($feedbacks);



            $projectDtos[] = $projectDto;
        }

        return $projectDtos;

    }

    public function getProjectById(string $id) : ProjectDto {
        $project = $this->projectRepository->findOneBy(['token_id'=>$id]);

        $projectDto = new ProjectDto();

        $users = [];
        $feedbacks = [];


        foreach($project->getUsers() as $user){
            $users[] = [
                'id' => $user->getTokenId(),
                'name' => $user->getFirstName() . " " . $user->getLastName(),
                'roles' => $user->getRoles(),
              ];
        }

        foreach($project->getFeedbacks() as $feedback){
            $feedbacks[] = [
                'id' => $feedback->getTokenId(),
                'status' => $feedback->getStatus()
              ];
        }

        $creator=[
            'id' => $project->getCreator()->getTokenId(),
            'name'=>$project->getCreator()->getFirstName() . " " . $project->getCreator()->getLastName(),
            'roles' =>$project->getCreator()->getRoles(),  
        ];

        $projectDto = new ProjectDto();
        $projectDto->setId($project->getTokenId());
        $projectDto->setTitle($project->getTitle());
        $projectDto->setClient($project->getClient());
        $projectDto->setStatus($project->getStatus());
        $projectDto->setDescription($project->getDescription());
        $projectDto->setRepo($project->getRepo());
        $projectDto->setCreatedAt($project->getCreatedAt()->format('Y-m-d H:i:s'));
        $projectDto->setModifiedAt($project->getModifiedAt()->format('Y-m-d H:i:s'));
        $projectDto->setUsersId($users);
        $projectDto->setCreator($creator);
        $projectDto->setFeedbacks($feedbacks);


        return $projectDto;

    }

    

    public function updateProject(Request $request,string $id): void {

        $project =$this->projectRepository->findOneBy(['token_id' => $id]);

        $data = json_decode($request->getContent(), true);

        if (isset($data['title'])) { $project->setTitle($data['title']);}
        if (isset($data['description'])) { $project->setDescription($data['description']);}
        if (isset($data['client'])) { $project->setClient($data['client']);}
        if (isset($data['status'])) { $project->setStatus($data['status']);}
        if (isset($data['repo'])) { $project->setRepo($data['repo']);}


        if (isset($data['usersId'])){

            $usersId = $data['usersId'];
            
            foreach($project->getUsers() as $user){
                $project->removeUser($user);
            }

            foreach ($usersId as $userId) {
                $user =  $this->userRepository->findOneBy(['token_id' => $userId]);
                $project->addUser($user);
            }
        }
        

    
        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();


    }

    public function deleteProject(string $id): void {

        $project =$this->projectRepository->findOneBy(['token_id' => $id]);
        $entityManger =$this->doctrine->getManager();

        $feedsbacks = $project->getFeedbacks();

        foreach($feedsbacks as $feedback){
            $entityManger->remove($feedback);
        }

        $entityManger->remove($project);
        $entityManger->flush();

    }


}