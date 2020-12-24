<?php

namespace App\Controller;

use App\Entity\Asociacion;
use App\Form\AsociacionType;
use App\Repository\AsociacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/asociacion")
 */
class AsociacionController extends AbstractController
{
    /**
     * @Route("/", name="asociacion_index", methods={"GET"})
     */
    public function index(AsociacionRepository $asociacionRepository): Response
    {
        return $this->render('asociacion/index.html.twig', [
            'asociacions' => $asociacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="asociacion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $asociacion = new Asociacion();
        $form = $this->createForm(AsociacionType::class, $asociacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($asociacion);
            $entityManager->flush();

            return $this->redirectToRoute('asociacion_index');
        }

        return $this->render('asociacion/new.html.twig', [
            'asociacion' => $asociacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="asociacion_show", methods={"GET"})
     */
    public function show(Asociacion $asociacion): Response
    {
        return $this->render('asociacion/show.html.twig', [
            'asociacion' => $asociacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="asociacion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Asociacion $asociacion): Response
    {
        $form = $this->createForm(AsociacionType::class, $asociacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('asociacion_index');
        }

        return $this->render('asociacion/edit.html.twig', [
            'asociacion' => $asociacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="asociacion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Asociacion $asociacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$asociacion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($asociacion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('asociacion_index');
    }
}
