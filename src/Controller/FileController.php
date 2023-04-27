<?php

namespace App\Controller;

use App\DataTransferObjects\FileDto;
use App\Entity\File;
use App\Repository\FeedbackRepository;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class FileController extends AbstractController
{

    public function __construct( private ManagerRegistry $doctrine,
    private EntityManagerInterface $entityManager,
    private FeedbackRepository $feedbackRepository,
    private FileRepository $fileRepository,
    private Packages $storage,
    private LoggerInterface $logger)
    {  

    }

    #[Route('/files',name:'app_files_upload',methods:"POST")]
    public function createFile(Request $request):JsonResponse{

        $files = $request->files->get('files');

        if (!$files) {
            return new JsonResponse(['messsage' => 'No Files Provided'], 201); 
        }

        $feedbackId = $request->request->get('feedbackId');

         // handle each  file here
         foreach ($files as $file) {
            // do something with the , like move it to a directory
            $tokenId = md5(uniqid(true));
            $extension = $file->getClientOriginalExtension();

            

            $file->move(
                $this->getParameter('files_directory'),
                $tokenId.'.'.$extension
            );

            $fileDB = new File();
            $fileDB->setFileName($file->getClientOriginalName());
            $fileDB->setFileExtension($extension);
            $fileDB->setCreatorId($request->request->get('creatorId'));
            $fileDB->setTokenId($tokenId);


            $feedback = $this->feedbackRepository->findOneBy(['token_id'=>$feedbackId]);
            $fileDB->setFeedback($feedback);

            $this->entityManager->persist($fileDB);
            $this->entityManager->flush();
            
        }
    
        return new JsonResponse(['messsage' => 'Files Added successfully'], 201); 
    }

    #[Route('/files/{feedbackId}', name: 'app_files_get', methods: ['GET'])]
    public function getFeedbackFiles(string $feedbackId): JsonResponse
    {
        $feedback = $this->feedbackRepository->findOneBy(['token_id'=>$feedbackId]);

        if (!$feedback) {
            return new JsonResponse(['message' => 'Feedback not found'], 404);
        }

        $files = $feedback->getFiles();


        $fileDtos =[];

        foreach ($files as $file) {

            $fileDto = new FileDto();
            $fileDto->setId($file->getTokenId());
            $fileDto->setFileName($file->getFileName());
            $fileDto->setFileExtension($file->getFileExtension());
            $fileDto->setFileUrl("http://127.0.0.1:8000/api/v1/files/download/".
                                    $file->getTokenId().".".$file->getFileExtension());
            $fileDto->setCreatedAt($file->getCreatedAt()->format('Y-m-d H:i:s'));
            $fileDto->setModifiedAt($file->getModifiedAt()->format('Y-m-d H:i:s'));
            $fileDto->setCreatorId($file->getCreatorId());

            $fileDtos[] = $fileDto;
        }

        return $this->json($fileDtos);
        
    }


    #[Route('/files/download/{name}', name: 'file', methods: ['GET'])]
    public function getFile(string $name) : Response
    {

        $filepath = realpath($this->getParameter('kernel.project_dir').'/public/assets/fileUploads/'.$name);

        // Check if file exists
        if (!file_exists($filepath)) {
            throw $this->createNotFoundException();
        }

        $dotPosition = strpos($name, '.');
        $fileId = substr($name, 0, $dotPosition);
        $fileDB = $this->fileRepository->findOneBy(['token_id'=>$fileId]);


        // Set response headers
        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-Type', mime_content_type($filepath));

        $response->headers->set('Content-Disposition', 'attachment; filename="' .$fileDB->getFileName(). '";');

        $response->headers->set('Content-Length', filesize($filepath));
        $response->setContent(file_get_contents($filepath));

        return $response;

    }

    
    #[Route('/files/{name}', name: 'app_file_delete', methods: ['DELETE'])]
    public function fileDelete(string $name) : JsonResponse
    {

        $filepath = realpath($this->getParameter('kernel.project_dir').'/public/assets/fileUploads/'.$name);

        if (file_exists($filepath)) {
            unlink($filepath);

            $dotPosition = strpos($name, '.');
            $fileId = substr($name, 0, $dotPosition);

            $fileDB = $this->fileRepository->findOneBy(['token_id'=>$fileId]);

            $entityManger =$this->doctrine->getManager();
            $entityManger->remove($fileDB);
            $entityManger->flush();

            return new JsonResponse(['message' => 'File deleted successfully.'], 201);
        } else {
            return new JsonResponse(['message' => 'File not found.'], 404);
        }

    }



  

}