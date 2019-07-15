<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ExempleController extends AbstractController
{
    /**
     * @Route("/exemple", name="exemple")
     */
    public function index()
    {
        return $this->render('exemple/index.html.twig', [
            'controller_name' => 'ExempleController',
        ]);
    }
}
