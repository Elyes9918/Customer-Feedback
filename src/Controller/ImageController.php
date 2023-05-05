<?php

namespace App\Controller;

use App\DataTransferObjects\ImageDto;
use App\Entity\Image;
use App\Repository\FeedbackRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class ImageController extends AbstractController
{

    public function __construct( private ManagerRegistry $doctrine,
    private EntityManagerInterface $entityManager,
    private FeedbackRepository $feedbackRepository,
    private ImageRepository $imageRepository,
    private Packages $storage)
    {  

    }

    #[Route('/images',name:'app_images_upload',methods:"POST")]
    public function createImage(Request $request):JsonResponse{

        $images = $request->files->get('images');

        if (!$images) {
            return new JsonResponse(['messsage' => 'No Images Provided'], 201); 
        }

        $feedbackId = $request->request->get('feedbackId');

         // handle each image file here
         foreach ($images as $image) {
            // do something with the image, like move it to a directory
            $tokenId = md5(uniqid(true));
            $extension = $image->guessExtension();

            // $imgName = $tokenId.'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('images_directory'),
                $tokenId.'.'.$extension
            );

            $imageDB = new Image();
            $imageDB->setImageName($image->getClientOriginalName());
            $imageDB->setImageExtension($extension);
            $imageDB->setCreatorId($request->request->get('creatorId'));

            // $filePath = $image->getRealPath();
            // $imageSize = filesize($filePath);
            // $imageDB->setImageSize($imageSize);
            
            $imageDB->setTokenId($tokenId);


            $feedback = $this->feedbackRepository->findOneBy(['token_id'=>$feedbackId]);
            $imageDB->setFeedback($feedback);

            $this->entityManager->persist($imageDB);
            $this->entityManager->flush();
            
        }
    
        return new JsonResponse(['messsage' => 'Images Added successfully'], 201); 
    }

    #[Route('/images/{feedbackId}', name: 'app_images_get', methods: ['GET'])]
    public function getFeedbackImages(string $feedbackId): JsonResponse
    {
        $feedback = $this->feedbackRepository->findOneBy(['token_id'=>$feedbackId]);

        if (!$feedback) {
            return new JsonResponse(['message' => 'Feedback not found'], 404);
        }

        $images = $feedback->getImages();


        $imageDtos =[];

        foreach ($images as $image) {

            $imageDto = new ImageDto();
            $imageDto->setId($image->getTokenId());
            $imageDto->setImageName($image->getImageName());
            $imageDto->setImageExtension($image->getImageExtension());
            $imageDto->setImageUrl("http://127.0.0.1:8000/api/v1/images/static/".
                                    $image->getTokenId().".".$image->getImageExtension());
            $imageDto->setCreatedAt($image->getCreatedAt()->format('Y-m-d H:i:s'));
            $imageDto->setModifiedAt($image->getModifiedAt()->format('Y-m-d H:i:s'));
            $imageDto->setCreatorId($image->getCreatorId());

            $imageDtos[] = $imageDto;
        }

        return $this->json($imageDtos);
        
    }


    #[Route('/images/static/{img}', name: 'image', methods: ['GET'])]
    public function image(string $img) : Response
    {
        // .. add some security checks here

        $filepath = realpath($this->getParameter('kernel.project_dir').'/public/assets/uploads/'.$img);

        // $filepath = $this->storage->getUrl("/assets/uploads/".$img);

        $response = new Response(file_get_contents($filepath));

        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $img);

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }

    
    #[Route('/images/{img}', name: 'app_image_delete', methods: ['DELETE'])]
    public function imageDelete(string $img) : JsonResponse
    {

        $filepath = realpath($this->getParameter('kernel.project_dir').'/public/assets/uploads/'.$img);

        if (file_exists($filepath)) {
            unlink($filepath);

            $dotPosition = strpos($img, '.');
            $imageId = substr($img, 0, $dotPosition);

            $imageDB = $this->imageRepository->findOneBy(['token_id'=>$imageId]);

            $entityManger =$this->doctrine->getManager();
            $entityManger->remove($imageDB);
            $entityManger->flush();

            return new JsonResponse(['message' => 'Image deleted successfully.'], 201);
        } else {
            return new JsonResponse(['message' => 'Image not found.'], 404);
        }

    }



  

}