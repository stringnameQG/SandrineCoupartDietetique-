<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Criteria;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        // en cas de besoin de modification de roles commenter les lignes suivantes
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/registerindex/{page<\d+>?1}', name: 'app_register_index', methods: ['GET', 'POST'])]
    public function index(UserRepository $userRepository, int $page): Response
    {   // On défini le nombre de user par page dans une variable
        $userPerPage = 9;
        // On crée ensuite une variable qui contien les paramétres de notre méthode critéria
        $criteria = Criteria::create()
            ->setFirstResult(($page - 1) * $userPerPage)  // Défine la premiére user affiché
            ->setMaxResults($userPerPage);  // Définie le nombre de user affiché

        $users = $userRepository->matching($criteria);

        $totalusers = count($userRepository->matching(Criteria::create()));

        $totalPages = ceil($totalusers / $userPerPage);

        return $this->render('registration/index.html.twig', [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }
    
    #[Route('/{id}', name: 'app_register_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
    }
}
