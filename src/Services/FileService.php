<?php

namespace App\Services;

use App\Repository\FeedbackRepository;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Asset\Packages;

class FileService
{

    public function __construct(
        private ManagerRegistry $doctrine,
        private EntityManagerInterface $entityManager,
        private FeedbackRepository $feedbackRepository,
        private FileRepository $fileRepository,
        private Packages $storage,
        private LoggerInterface $logger
    ){ 
    }


}
