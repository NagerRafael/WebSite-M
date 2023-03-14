<?php

namespace App\Controller;
use App\Form\RegistrationFormType;
use App\Entity\User;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $uph, UserAuthenticatorInterface $uai, AppCustomAuthenticator $aca, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this -> createForm(RegistrationFormType::class, $user);
        $form -> handleRequest($request);
        
        if($form -> isSubmitted() && $form -> isValid()){
            
            $user -> setPassword(
                //Encriptación del password
                $uph -> hashPassword(
                    $user,
                    $form -> get('password') -> getData()
                )
            );

            $em -> persist($user);
            $em -> flush();

            return $uai -> authenticateUser(
                $user,
                $aca,
                $request
            );
        }
        
        return $this->render('register/index.html.twig', [
            'registrationForm' => $form -> createView(),
        ]);
    }
}
