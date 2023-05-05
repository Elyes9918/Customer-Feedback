<?php

namespace App\Services;

use App\DataTransferObjects\UserDto;
use App\Repository\FeedbackRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class UserService{

    
    public function __construct(
        private UserRepository $userRepository,
        private ManagerRegistry $doctrine,
        private ProjectRepository $projectRepository,
        private FeedbackRepository $feedbackRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private MailerInterface $mailer,
        private ResetPasswordHelperInterface $resetPasswordHelper)
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
            $userDto->setId($user->getTokenId());
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
            $userDto->setCountry($user->getCountry());
            $userDto->setLastLogin($user->getLastLogin() ? $user->getLastLogin()->format('Y-m-d H:i:s') : null);
            $userDto->setProjectsId($projects);
            $userDto->setFeedbacksId($feedbacks);
            $userDto->setRoles($user->getRoles());
            $userDto->setIsVerified($user->isVerified());

            $userDtos[] = $userDto;
        }

        return $userDtos;
    }


    
    public function getUserById(string $id) : UserDto {

        $user = $this->userRepository->findOneBy(['token_id' => $id]);

        $userDto = new UserDto();
        $projects = [];
        $feedbacks = [];

        foreach($user->getProjects() as $project){
            $projects[] = $project->getId();
        }

        foreach($user->getFeedbacks() as $feedback){
            $feedbacks[] = $feedback->getId() ;
        }

        $userDto->setId($user->getTokenId());
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
        $userDto->setCountry($user->getCountry());
        $userDto->setNotificationIsOn($user->getNotificationIsOn());
        $userDto->setLastLogin($user->getLastLogin() ? $user->getLastLogin()->format('Y-m-d H:i:s') : null);
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
            $projects[] = $project->getId();
        }

        foreach($user->getFeedbacks() as $feedback){
            $feedbacks[] = $feedback->getId() ;
        }

        $userDto->setId($user->getTokenId());
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
        $userDto->setCountry($user->getCountry());
        $userDto->setNotificationIsOn($user->getNotificationIsOn());
        $userDto->setLastLogin($user->getLastLogin() ? $user->getLastLogin()->format('Y-m-d H:i:s') : null);
        $userDto->setProjectsId($projects);
        $userDto->setFeedbacksId($feedbacks);
        $userDto->setRoles($user->getRoles());
        $userDto->setIsVerified($user->isVerified());

        return $userDto;
    }
    

    public function updateUser(Request $request,string $id): void {
       

        $user = $this->userRepository->findOneBy(['token_id' => $id]);

        $data = json_decode($request->getContent(), true);

        if (isset($data['email'])) { $user->setEmail($data['email']);}

        if (isset($data['firstName'])) { $user->setFirstName($data['firstName']);  }

        if (isset($data['lastName'])) { $user->setLastName($data['lastName']); }

        if (isset($data['birthDate'])) { $user->setBirthDate($data['birthDate']); }

        if (isset($data['status'])) { $user->setStatus($data['status']); }

        if (isset($data['address'])) { $user->setAddress($data['address']); }

        if (isset($data['phoneNumber'])) { $user->setPhoneNumber($data['phoneNumber']); }

        if (isset($data['company'])) { $user->setCompany($data['company']); }

        if (isset($data['country'])) { $user->setCountry($data['country']); }

        if (isset($data['notificationIsOn'])) { $user->setNotificationIsOn($data['notificationIsOn']); }

        if (isset($data['lastLogin'])) { $user->setLastLogin($data['lastLogin']); }

        if (isset($data['isVerified'])) {

             $user->setIsVerified($data['isVerified']);

             if($data['isVerified']==true){


                try {
                    $resetToken = $this->resetPasswordHelper->generateResetToken($user);
                } catch (ResetPasswordExceptionInterface $e) {
        
                }
        

                $email = (new TemplatedEmail())
                ->from(new Address('mailer@wevioo.com', 'Wevioo'))
                ->to($user->getEmail())
                ->subject("Configure your password Wevioo-Customer-Feedback")
                ->htmlTemplate('emails/configurePassword.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                    'userFirstName'  => $user->getFirstName(),
                    'userLastName'  => $user->getLastName()
                ]);
                
    
                $this->mailer->send($email);
             }

            }


        if (isset($data['password'])) { 

            $encodedPassword = $this->passwordHasher->hashPassword(
                $user,
                $data['password']
            );


            $user->setPassword($encodedPassword);
         }

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
            //I need to created a roles table assign to it User ROLE
            //and then take the string recived split it into roles
            // and push them into the array of roles and then set it to user and flush
            $roles = ["ROLE_USER"];

            $roles_arr = explode(',', $data['roles']);
        
            foreach ($roles_arr as $role) {
                // Remove any empty elements
                $role = trim($role);
                if ($role != '') {
                  // Add the remaining elements to the $roles array
                  $roles[] = $role;
                }
              }

            $user->setRoles($roles); 
        }
    
        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();

    }



    public function unAssignRole(Request $request,string $id): void {

        $user = $this->userRepository->findOneBy(['token_id' => $id]);

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

    public function unAssignProject(Request $request,string $id): void {

        $user = $this->userRepository->findOneBy(['token_id' => $id]);

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

    public function unAssignFeedBack(Request $request,string $id): void {

        $user = $this->userRepository->findOneBy(['token_id' => $id]);

        $data = json_decode($request->getContent(), true);

        //Logic to remove a feedback from a user
        $feedback = $this->feedbackRepository->find($data['feedbackId']);
        $user->removeFeedback($feedback);

        $entityManger = $this->doctrine->getManager();
        $entityManger->flush();

    }






}
