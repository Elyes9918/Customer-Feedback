<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use App\Security\EmailVerifier;
use DateTimeImmutable;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/api')]
class AuthenticationController extends AbstractController {

    use ResetPasswordControllerTrait;


    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier,private ResetPasswordHelperInterface $resetPasswordHelper,
    private EntityManagerInterface $entityManager,private UserRepository $userRepository,
    private ManagerRegistry $doctrine,)
    {
        $this->emailVerifier = $emailVerifier;
    }


    #[Route('/register', name: 'app_register', methods: "POST")]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {


        $user = new User();
        $data = json_decode($request->getContent(), true);

        $user->setEmail($data['email']);
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,"JF#3A&*f5PZ!cK"
            )
        );
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setBirthDate($data['birthDate']);
        $user->setAddress($data['address']);
        $user->setPhoneNumber($data['phoneNumber']);
        $user->setCompany($data['company']);
        $user->setCountry($data['country']);
        $user->setRoles([]);
        $user->setNotificationIsOn(1);
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setStatus(USER::STATUS_NOT_ACTIVATED);
        $user->setIsVerified(0);
        $user->setTokenId(md5(uniqid($data['email'], true)));


        
        $entityManager->persist($user);
        $entityManager->flush();

        // generate a signed url and email it to the user
        // $this->emailVerifier->sendEmailConfirmation(
        //     'app_verify_email',
        //     $user,
        //     (new TemplatedEmail())
        //         ->from(new Address('mailer@mailer.de', 'mailer bot'))
        //         ->to($user->getEmail())
        //         ->subject('Please Confirm your Email')
        //         ->htmlTemplate('registration/confirmation_email.html.twig')
        // );

        // // do anything else you need here, like send an email
        $email = (new TemplatedEmail())
            ->from(new Address('mailer@wevioo.com', 'Wevioo'))
            ->to("Elyes@gmail.com")
            ->subject($data['email'] . ' Has joined the platfrom')
            ->htmlTemplate('emails/newAccount.html.twig')
            ->context([
                'userEmail' => $data['email'],
                'company'  => $data['company'],
                'createdAt'=> $user->getCreatedAt()->format('Y-m-d H:i:s'),
                'id'=>$user->getTokenId()
            ]);

         $mailer->send($email);


        return new JsonResponse(['messsage' => 'User Created successfully'], 201); 
    }



    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {

        $user = new User();
        $data = json_decode($request->getContent(), true);
        $user->setEmail($data['email']);
        $user->setId($data['id']);
        
        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return new JsonResponse(['messsage' => 'User is not Verified successfully'], 201);
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return new JsonResponse(['messsage' => 'User Verified successfully'], 201);
    }




    #[Route('/reset-password', name: 'app_forgot_password_request',methods:'POST')]
    public function request(Request $request, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        
        $email = json_decode($request->getContent(), true);

            return $this->processSendingPasswordResetEmail(
                $email['email'],
                $mailer,
                $translator
            );
        
    }


    /**
     * Confirmation page after a user has requested a password reset.
     */
    #[Route('/reset-password/check-email', name: 'app_check_email')]
    public function checkEmail(): Response
    {
        // Generate a fake token if the user does not exist or someone hit this page directly.
        // This prevents exposing whether or not a user was found with the given email address or not
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */
    #[Route('/reset-password/reset/{token}', name: 'app_reset_password',methods:'POST')]
    public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, TranslatorInterface $translator, string $token = null): Response
    {

        //if i uncomment this the requesut wont work because it will execute a get request first then 
        //its a post request thats why i i avoided storing the token in the session and stored it in the URL
        /*
       
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('app_reset_password');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }
        */

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                '%s - %s',
                $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE, [], 'ResetPasswordBundle'),
                $translator->trans($e->getReason(), [], 'ResetPasswordBundle')
            ));

            return $this->redirectToRoute('app_forgot_password_request');
        }

        // The token is valid; allow the user to change their password.
        
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            $password = json_decode($request->getContent(), true);

            // Encode(hash) the plain password, and set it.
            $encodedPassword = $passwordHasher->hashPassword(
                $user,
                $password['password']
            );

            $user->setPassword($encodedPassword);
            $this->entityManager->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            return new JsonResponse(['message'=>'Password Changed Succesfully']);
        
        
    }



    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer, TranslatorInterface $translator): RedirectResponse
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
        if (!$user) {
            return $this->redirectToRoute('app_check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'app_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            // $this->addFlash('reset_password_error', sprintf(
            //     '%s - %s',
            //     $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_HANDLE, [], 'ResetPasswordBundle'),
            //     $translator->trans($e->getReason(), [], 'ResetPasswordBundle')
            // ));

            return $this->redirectToRoute('app_check_email');
        }

        $email = (new TemplatedEmail())
            ->from(new Address('mailer@domain.de', 'mailer bot'))
            ->to($user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
                'userFirstName'  => $user->getFirstName(),
                'userLastName'  => $user->getLastName(),
            ])
        ;

        $mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('app_check_email');
    }

}