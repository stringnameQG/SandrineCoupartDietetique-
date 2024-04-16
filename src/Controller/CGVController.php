<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CGVController extends AbstractController
{
  #[Route('/cgv', name: 'app_cgv', methods: ['GET'])]
  public function CGV(Request $request, EntityManagerInterface $entityManager) : Response
  {
    return $this->render('cgv/CGV.html.twig');
  }
}