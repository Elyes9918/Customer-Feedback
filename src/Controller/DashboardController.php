<?php

namespace App\Controller;

use App\Services\DashboardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class DashboardController extends AbstractController
{

    public function __construct(private DashboardService $dashboardService)
    {  }

    #[Route('/dashboard/data', name: 'app_dashboard_admin_get', methods: "GET")]
    public function index(): JsonResponse
    {
        $dashboardDto = $this->dashboardService->dashboardData();
       
        return $this->json($dashboardDto);
    }
    

}