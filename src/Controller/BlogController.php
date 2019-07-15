<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Employe;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface ;
use App\Entity\Service;
use App\Repository\EmployeRepository;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Extension\Core\Type\SubmitType;
//use App\Repository\EmployeRepository;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */ 
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /**
     * @Route("/", name="acceuil")
     */
    public function acceuil()
    {
        return $this->render('blog/acceuil.html.twig');
    }
   
    /**
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Request $request, ObjectManager $manager) {
     
   
        $employe= new Employe();
           
     $form = $this->createFormBuilder($employe)
                ->add('matricule')
                ->add('nomcomplet')
                
                ->add('datenaissance', DateType::class, ['widget' => "single_text",
                                                          'format' => "yyyy-MM-dd"  ])
                ->add('salaire')
                ->add('service', EntityType::class,[
                    'class' => Service::class,
                    'choice_label' => 'libelle',
                ])
                ->getForm(); 
                $form->handleRequest($request);


                 
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($employe);
            $manager->flush();
        }
    return $this->render('blog/formulaire.html.twig', [
        'formEmploye' => $form->createView()
    ]) ;                  
    }

    /**
     * @Route("/blog/recuperer", name="recuperer")
     */

    public function show()
    {
        $product = $this->getDoctrine()
            ->getRepository(Employe::class );
            $emp=$product->findAll();
        
       return $this->render('blog/listemp.html.twig', [
           'controller_name' => 'BlogController', 'emps' => $emp
       ]);
        
    }
    /**
     * @Route("/form1/{id}/supempl", name="supempl")
     */
    public function delEmploye(Employe $employer=null, ObjectManager $manager){
        $manager->remove($employer);
        $manager->flush();
        return $this->redirectToRoute('form1', ['id'=>$employer->getId()]);
    }
   
      
     }

