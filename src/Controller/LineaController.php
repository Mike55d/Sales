<?php

namespace App\Controller;

use App\Entity\Linea;
use App\Form\LineaType;
use App\Repository\LineaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/linea")
 */
class LineaController extends AbstractController
{
    /**
     * @Route("/", name="linea_index", methods={"GET"})
     */
    public function index(LineaRepository $lineaRepository): Response
    {
        return $this->render('linea/index.html.twig', [
            'lineas' => $lineaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="linea_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $linea = new Linea();
        $form = $this->createForm(LineaType::class, $linea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($linea);
            $entityManager->flush();

            return $this->redirectToRoute('linea_index');
        }

        return $this->render('linea/new.html.twig', [
            'linea' => $linea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="linea_show", methods={"GET"})
     */
    public function show(Linea $linea): Response
    {
        return $this->render('linea/show.html.twig', [
            'linea' => $linea,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="linea_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Linea $linea): Response
    {
        $form = $this->createForm(LineaType::class, $linea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('linea_index');
        }

        return $this->render('linea/edit.html.twig', [
            'linea' => $linea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="linea_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Linea $linea): Response
    {
        if ($this->isCsrfTokenValid('delete'.$linea->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($linea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('linea_index');
    }
}
