<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnectionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/users/add', name: 'app_users_add')] 
//     public function addUser(UserPasswordEncoderInterface 
// $passwordEncoder, EntityManagerInterface $entityManager) 
   public function addUser(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager,Request $request):Response
 
   { 
        // Créer une instance de l'entité User 
        $user = new User(); 
        $form = $this->createForm(ConnectionType::class, $user); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) 
        { $user = $form->getData(); 
            $textPassword = $user->getPassword(); 
            $hashedPassword = $passwordHasher->hashPassword($user, 
            $textPassword); 
            $user->setPassword($hashedPassword); 
            $user->setRoles(['ROLE_USER']); 
            $entityManager->persist($user); 
            $entityManager->flush(); 
        } 
 
        return $this->render('user/addUser.html.twig', [ 
            'form' => $form->createView() 
            ]); 
 } 
}
