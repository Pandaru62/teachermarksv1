<?php

namespace App\Controller;

use Symfony\Component\Form\FormFactoryInterface;
use App\Entity\SkillScale;
use App\Form\SkillScaleFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SkillScaleController extends AbstractController
{
    private $em;
    private $formFactory;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }


    // #[Route('/editSkillScale', name: 'skill_scale')]
    // public function editSkillScale(Request $request): Response
    // {
    //     $repository = $this->em->getRepository(SkillScale::class);
    //     $skillScales = $repository->findAll();

    //     if (!$skillScales) {
    //         throw $this->createNotFoundException('Erreur');
    //     }

    //     $forms = [];
    //     foreach ($skillScales as $skillScale) {
    //         $form = $this->createForm(SkillScaleFormType::class, $skillScale);
    //         $form->handleRequest($request);

    //         if ($form->isSubmitted() && $form->isValid()) {
    //             $this->em->persist($skillScale);
    //         }

    //         $forms[] = $form->createView();
    //     }

    //     if ($request->isMethod('POST')) {
    //         $this->em->flush();
    //         return $this->redirectToRoute('skill_scale');
    //     }

    //     return $this->render('config/editSkillScale.html.twig', [
    //         'forms' => $forms,
    //     ]);
    // }

}



