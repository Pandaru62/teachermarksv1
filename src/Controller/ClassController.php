<?php

namespace App\Controller;

use App\Entity\Schoolclass;

use Symfony\Component\HttpFoundation\Request;
use App\Form\SchoolclassFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClassController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;

    }


    #[Route('/voirclasses', name: 'app_class')]
    public function index(): Response
    {
        $repository = $this->em->getRepository(Schoolclass::class);
        $archivedClasses = $repository->findBy([
            'isArchived' => 1
            ]);
        $activeClasses = $repository->findBy([
        'isArchived' => 0
        ]);

        return $this->render('class/showall.html.twig', [
            'archivedClasses' => $archivedClasses, 'activeClasses' => $activeClasses
        ]);
    }

    #[Route('/editclass/{classid}', methods: ['GET', 'POST'], name: 'edit_class')]
    public function editSchoolClass($classid, Request $request): Response
    {
        $repository = $this->em->getRepository(Schoolclass::class);
        $class = $repository->find($classid);
        $form = $this->createForm(SchoolclassFormType::class, $class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $class->setName($form->get('name')->getData());
            $class->setIsArchived($form->get('isArchived')->getData());
            $class->setColor($form->get('color')->getData());
            $class->setForm($form->get('form')->getData());

            $this->em->flush();
            return $this->redirectToRoute('app_class');
        }

        return $this->render('class/edit.html.twig', [
            'class' => $class,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/deleteclass/{classid}', methods: ['GET', 'DELETE'], name: 'delete_class')]
    public function deleteSchoolClass($classid): Response
    {
        $classRepo = $this->em->getRepository(Schoolclass::class);
        $class = $classRepo->find($classid);
        $this->em->remove($class);
        $this->em->flush();

        return $this->redirectToRoute('app_class');
    }

    
    #[Route('/addclass', name: 'add_class')]
    public function addSchoolClass(Request $request): Response
    {
        $newSchoolclass = new Schoolclass();
        $form = $this->createForm(SchoolclassFormType::class, $newSchoolclass);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newSchoolclass = $form->getData();

            $this->em->persist($newSchoolclass);
            $this->em->flush();
    
            return $this->redirectToRoute('app_class');
    
        }

        
        return $this->render('class/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/archiveclass/{classid}', methods: ['GET'], name: 'archive_class')]
    public function archiveSchoolClass($classid, Request $request): Response
    {
        $repository = $this->em->getRepository(Schoolclass::class);
        $class = $repository->find($classid);

        $class->setIsArchived(true);

        $this->em->flush();
        return $this->redirectToRoute('app_class');
    }
    
}



