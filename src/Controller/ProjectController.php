<?php

namespace App\Controller;

use App\DataTransferObjects\ProjectDto;
use App\Entity\Project;
use App\Services\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class ProjectController extends AbstractController
{

    public function __construct(private ProjectService $projectService)
    {  
        
    }

    #[Route('/projects',name:'app_projects_create',methods:"POST")]
    public function createProject(Request $request):JsonResponse{
        
        $this->projectService->createProject($request);

        return new JsonResponse(['messsage' => 'Project Created successfully'], 201); 
    }



    #[Route('/projects', name: 'app_projects_get', methods: "GET")]
    public function index(): JsonResponse
    {   
        $projectsDtos = $this->projectService->listAllProjects();
       
        return $this->json($projectsDtos);
    }


    #[Route('/projects/{id}', name: 'app_project_get', methods: "GET")]
    public function getUserById(string $id): JsonResponse
    {
        $projectDto = new ProjectDto();
        $projectDto = $this->projectService->getProjectById($id);
        
        return $this->json($projectDto);
    }

    
    #[Route('/projects/user/{id}', name: 'app_project_get_byIdUser', methods: "GET")]
    public function getProjectsByIdUser(string $id): JsonResponse
    {
        $projectDtos = $this->projectService->getProjectsByIdPersonne($id);
        
        return $this->json($projectDtos);
    }

    #[Route('/projects/{id}', name: 'app_projects_patch', methods: "PATCH")]
    public function updateProject(Request $request,string $id): JsonResponse
    {
        
        if ($id == null) {
            return new JsonResponse("id is incorrect", 200, [], true);
        }
        

        $this->projectService->updateProject($request,$id);

        return new JsonResponse(['meesage' => 'Project updated succesfully'], 200);
    }

    #[Route('/projects/{id}', name: 'app_projects_delete', methods:"DELETE")]
    public function deleteProject(string $id): JsonResponse
    {

       $this->projectService->deleteProject($id);

        return new JsonResponse([
            'message' => 'Project deleted succesfully',
        ], 404);
    }

    

}
