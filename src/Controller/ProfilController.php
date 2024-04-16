<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
  #[Route('/monprofil', name: 'app_monprofil', methods: ['GET', 'POST'])]
  public function MonProfil(Request $request, EntityManagerInterface $entityManager) : Response
  {
    $user = $this->getUser();

    // $User = new User();
    $form = $this->createForm(RegistrationFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('monprofil/monprofil.html.twig', [
        'user' => $user,
        'registrationForm' => $form,
    ]);
  }
}