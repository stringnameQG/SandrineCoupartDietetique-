<?php
namespace App\Controller;

use App\Entity\Contacte;
use App\Form\ContacteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contacteCLI')]
class AffichageContacteController extends AbstractController
{
    #[Route('', name: 'app_contacte', methods: ['GET', 'POST'])]
    public function affichage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contacte = new Contacte();
        $form = $this->createForm(ContacteType::class, $contacte);
        $form->handleRequest($request);
  
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contacte);
            $entityManager->flush();
  
            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        }
  
        return $this->render('contacte/affichage.html.twig', [
            'form' => $form,
        ]);
    }
}