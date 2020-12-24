<?php

namespace App\Controller;

use App\Entity\Operadora;
use App\Form\OperadoraType;
use App\Repository\OperadoraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/operadora")
 */
class OperadoraController extends AbstractController
{
    /**
     * @Route("/", name="operadora_index", methods={"GET"})
     */
    public function index(OperadoraRepository $operadoraRepository): Response
    {
        return $this->render('operadora/index.html.twig', [
            'operadoras' => $operadoraRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="operadora_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $operadora = new Operadora();
        $form = $this->createForm(OperadoraType::class, $operadora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operadora);
            $entityManager->flush();
            return $this->redirectToRoute('operadora_index');
        }

        return $this->render('operadora/new.html.twig', [
            'operadora' => $operadora,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="operadora_show", methods={"GET"})
     */
    public function show(Operadora $operadora): Response
    {
        return $this->render('operadora/show.html.twig', [
            'operadora' => $operadora,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="operadora_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Operadora $operadora): Response
    {
        $form = $this->createForm(OperadoraType::class, $operadora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operadora_index');
        }

        return $this->render('operadora/edit.html.twig', [
            'operadora' => $operadora,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="operadora_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Operadora $operadora): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operadora->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operadora);
            $entityManager->flush();
        }

        return $this->redirectToRoute('operadora_index');
    }
}
