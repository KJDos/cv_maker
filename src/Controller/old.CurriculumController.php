<?php

namespace App\Controller;

use App\Entity\Curriculum;
use App\Form\CurriculumType;
use App\Repository\CurriculumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/curriculum")
 */
class CurriculumController extends AbstractController
{
    /**
     * @Route("/", name="curriculum_index", methods={"GET"})
     */
    public function index(CurriculumRepository $curriculumRepository): Response
    {
        return $this->render('curriculum/index.html.twig', [
            'curricula' => $curriculumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="curriculum_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $curriculum = new Curriculum();
        $form = $this->createForm(CurriculumType::class, $curriculum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($curriculum);
            $entityManager->flush();

            return $this->redirectToRoute('curriculum_index');
        }

        return $this->render('curriculum/new.html.twig', [
            'curriculum' => $curriculum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="curriculum_show", methods={"GET"})
     */
    public function show(Curriculum $curriculum): Response
    {
        return $this->render('curriculum/show.html.twig', [
            'curriculum' => $curriculum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="curriculum_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Curriculum $curriculum): Response
    {
        $form = $this->createForm(CurriculumType::class, $curriculum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('curriculum_index');
        }

        return $this->render('curriculum/edit.html.twig', [
            'curriculum' => $curriculum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="curriculum_delete", methods={"POST"})
     */
    public function delete(Request $request, Curriculum $curriculum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$curriculum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($curriculum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('curriculum_index');
    }
}
