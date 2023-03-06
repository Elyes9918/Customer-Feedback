<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FeedbackRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api/v1')]
class UserController extends AbstractController
{

    public function __construct(
    private UserRepository $userRepository,
    private ManagerRegistry $doctrine,
    private ProjectRepository $projectRepository,
    private FeedbackRepository $feedbackRepository)
    {    

    }


    #[Route('/users', name: 'app_users_get', methods: "GET")]
    public function index(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $data = [];
    
    
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

 
            $data[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'created_at'=>$user->getCreatedAt()->format('Y-m-d H:i:s'),
                'modified_at'=> $user->getModifiedAt()->format('Y-m-d H:i:s'),
                'first_name'=> $user->getFirstName(),
                'last_name'=>$user->getLastName(),
                'birth_date'=>$user->getBirthDate(),
                'status'=>$user->getStatus(),
                'address'=>$user->getAddress(),
                'phone_number'=>$user->getPhoneNumber(),
                'company'=>$user->getCompany(),
                'projects_id'=>$projects,
                'feedbacks_id'=>$feedbacks,
                'roles'=> $user->getRoles(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/users/{id}', name: 'app_user_get', methods: "GET")]
    public function getUserById(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        $data = [];
        $projects = [];
        $feedbacks = [];

        foreach($user->getProjects() as $project){
            // $projects[] = ['id' => $project->getId() ]; //this is an object 
            $projects[] = $project->getId();
        }

        foreach($user->getFeedbacks() as $feedback){
            $feedbacks[] = $feedback->getId() ;
        }


        $data = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'created_at'=>$user->getCreatedAt()->format('Y-m-d H:i:s'),
            'modified_at'=> $user->getModifiedAt()->format('Y-m-d H:i:s'),
            'first_name'=> $user->getFirstName(),
            'last_name'=>$user->getLastName(),
            'birth_date'=>$user->getBirthDate(),
            'status'=>$user->getStatus(),
            'address'=>$user->getAddress(),
            'phone_number'=>$user->getPhoneNumber(),
            'company'=>$user->getCompany(),
            'projects_id'=>$projects,
            'feedbacks_id'=>$feedbacks,
            'roles'=> $user->getRoles(),
            ]
        ;
        

        return $this->json($data);
    }

    #[Route('/users/{id}', name: 'app_users_patch', methods: "PATCH")]
    public function update(Request $request,int $id): JsonResponse
    {
        
        if ($id == null) {
            return new JsonResponse("id is incorrect", 200, [], true);
        }

        $user = $this->userRepository->find($id);


        $data = json_decode($request->getContent(), true);

        if (isset($data['email'])) { $user->setEmail($data['email']);  }

        if (isset($data['first_name'])) { $user->setFirstName($data['first_name']);  }

        if (isset($data['last_name'])) { $user->setLastName($data['last_name']); }

        if (isset($data['birth_date'])) { $user->setBirthDate($data['birth_date']); }

        if (isset($data['status'])) { $user->setStatus($data['status']); }

        if (isset($data['address'])) { $user->setAddress($data['address']); }

        if (isset($data['phone_number'])) { $user->setPhoneNumber($data['phone_number']); }

        if (isset($data['company'])) { $user->setCompany($data['company']); }

        if (isset($data['project_id'])) { 
            //Logic to assign a single project with an id passed 
            $project = $this->projectRepository->find($data['project_id']);
            $user->addProject($project);
        }

        if (isset($data['feedback_id'])) {
            //Logic to assign a signle feedback with an id passed
            $feedback = $this->feedbackRepository->find($data['feedback_id']);
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

        return new JsonResponse(['meesage' => 'User updated succesfully'], 200);

    }


     #[Route('/users/{id}/role', name:'app_user_role_unassign', methods: "PATCH")]
     public function unAssignRole(Request $request,int $id):JsonResponse{

        if ($id == null) {
            return new JsonResponse("id is incorrect", 200, [], true);
        }

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

        return new JsonResponse(['message'=>'Role Unassigned Successfuly'],200);
     }

    #[Route('/users/{id}/project', name:'app_user_project_unassign', methods: "PATCH")]
    public function unAssignProject(Request $request,int $id):JsonResponse{

        if ($id == null) {
            return new JsonResponse("id is incorrect", 200, [], true);
        }

        $user = $this->userRepository->find($id);

        $data = json_decode($request->getContent(), true);

        //Logic to remove a project from a user
        //Automatically remove all feedbacks related to that project from this user
        //I have to get all the feedbacks related to the project then unassign them from the user
        
        $feedbacks = $this->feedbackRepository->findBy(array("project"=>$data['project_id']));
        foreach($feedbacks as $feedback){
            $user->removeFeedback($feedback);
        }

        $project = $this->projectRepository->find($data['project_id']);
        $user->removeProject($project);
        


        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();

        return new JsonResponse(['message'=>'Project Unassigned Successfuly'],200);
    }


    #[Route('/users/{id}/feedback', name:'app_user_feedback_unassign', methods: "PATCH")]
    public function unAssignFeedback(Request $request,int $id):JsonResponse{

        if ($id == null) {
            return new JsonResponse("id is incorrect", 200, [], true);
        }

        $user = $this->userRepository->find($id);

        $data = json_decode($request->getContent(), true);

        //Logic to remove a feedback from a user
        $feedback = $this->feedbackRepository->find($data['feedback_id']);
        $user->removeFeedback($feedback);

        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();

        return new JsonResponse(['message'=>'Feedback Unassigned Successfuly'],200);
    }


    #[Route('/users/{id}', name: 'app_user_delete', methods: "DELETE")]
    public function deleteUser(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if ($user) {
            $entityManger = $this->doctrine->getManager();
            $entityManger->remove($user);
            $entityManger->flush();
            return new JsonResponse(['meesage' => 'User deleted succesfully'], 200);
        }

        return new JsonResponse(['message' => 'User not found'], 404);
    }
    
}
