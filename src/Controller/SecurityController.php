<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordType;
use App\Security\LoginFormAuthenticator;
use DateInterval;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @param MailerInterface $mailer
     * @return Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator,
        MailerInterface $mailer
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            if ($form->get('startDate')->getData()) {
                $startDate = clone $form->get('startDate')->getData();
                $endDate = $startDate->add(new DateInterval('P56D'));
                $user->setEndDate($endDate);
            }

            $user->setRoles(['ROLE_USER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            try {
                $email = (new Email())
                    ->from($this->getParameter('mailer_from'))
                    ->to($user->getEmail())
                    ->subject('Votre inscription sur Bobo-bidon')
                    ->html($this->renderView('email/registration.html.twig', ['user' => $user]));

                $mailer->send($email);

            } catch (TransportExceptionInterface $e) {

            }

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/reset/{user}", name="reset_password", methods={"GET","POST"})
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function reset(
        User $user,
        Request $request,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);

            $user->setPassword($encoded);

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profile', [
                'user' => $user->getId(),
            ]);
        }
        return $this->render('security/reset_password.html.twig', [
            'form' => $form->createView(),
            'User' => $user,
        ]);
    }
}
