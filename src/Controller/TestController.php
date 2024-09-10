<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestFormType;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;



class TestController extends AbstractController
{

    private $testRepository;
    private $em;

    public function __construct(TestRepository $testRepository, EntityManagerInterface $em) {
        $this->testRepository = $testRepository;
        $this->em = $em;
    }

    #[Route('/seetests', name: 'see_tests')]
    public function seeTests(): Response
    {

        $tests = $this->testRepository->findBy([], ['date' => 'DESC']);

        // Group tests by class

        $testsByClass = [];
    foreach ($tests as $test) {
        $classColor = $test->getSchoolclass()->getColor();
        $className = $test->getSchoolclass()->getName(); 
        if (!isset($testsByClass[$className])) {
            $testsByClass[$className] = [];
        }
        $testsByClass[$className]['tests'][] = $test;
        $testsByClass[$className]['color'] = $classColor;
    }
        
        // dd($testsByClass);
        return $this->render('tests/show.html.twig', [
            'tests' => $tests, 'testsByClass' => $testsByClass
        ]);
    }

    #[Route('/addtest', name: 'add_test')]
    public function addTest(Request $request): Response
    {

        $newTest = new Test();
        $form = $this->createForm(TestFormType::class, $newTest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newTest = $form->getData();

            $this->em->persist($newTest);
            $this->em->flush();

            return $this->redirectToRoute('see_tests');

        }

        return $this->render('tests/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edittest/{testid}', methods: ['GET'], name: 'edit_test')]
    public function editTest($testid, Request $request): Response
    {

        $test = $this->testRepository->find($testid);
        $form = $this->createForm(TestFormType::class, $test);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $test->setDescription($form->get('description')->getData());
            $test->setDate($form->get('date')->getData());
            $test->setTrimester($form->get('trimester')->getData());
            $test->setScale($form->get('scale')->getData());
            $test->setCoefficiemt($form->get('coefficient')->getData());
            $test->setSchoolclass($form->get('schoolclass')->getData());

            $this->em->flush();
            return $this->redirectToRoute('see_tests');
        }

        return $this->render('tests/edit.html.twig', [
            'test' => $test,
            'form' => $form,
        ]);
    }

    #[Route('/deletetest/{testid}', methods: ['GET', 'DELETE'], name: 'delete_test')]
    public function deleteTest(int $testid): Response
    {
        $test = $this->em->getRepository(Test::class)->find($testid);
        $this->em->remove($test);
        $this->em->flush();

        return $this->redirectToRoute('see_tests');
    }
    
}
