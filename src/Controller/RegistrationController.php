<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Mailer\RegistrationMailer;
use App\Repository\UserRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        RegistrationMailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user, ['standalone' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                )
            );

            $user->setActivationToken(Uuid::uuid4());
            $mailer->sendMail($user);



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email



            return $this->redirectToRoute('activation_needed');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activation/needed", name="activation_needed")
     */
    public function activationNeeded(){
        return $this->render('Registration/activationNeeded.html.twig');
    }

    /**
     * @Route("/account/activate/{token}", name="activate_account")
     */
    public function activateToken(
        string $token,
        TokenStorageInterface $tokenStorage
    ){

        $manager = $this->getDoctrine()->getManager();

        $userRepository = $manager->getRepository(User::class);

        $user = $userRepository->findOneByActivationToken($token);

        if(!$user)
        {
            throw new NotFoundHttpException('User not found');
        }

        $user->setActivationToken(null)
            ->setActive(true);

        $manager->flush();

        $tokenStorage->setToken(new UsernamePasswordToken($user,null,'main',$user->getRoles()));

        return $this->redirectToRoute("homepage");
    }
}
