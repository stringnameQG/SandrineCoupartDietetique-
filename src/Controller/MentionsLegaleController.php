<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MentionsLegaleController extends AbstractController
{
  #[Route('/mentionslegale', name: 'app_mentionslegale', methods: ['GET'])]
  public function MentionsLegale(
    Request $request, 
    EntityManagerInterface $entityManager) : Response
  {
    return $this->render('mentionLegale/MentionsLegale.html.twig');
  }
}
