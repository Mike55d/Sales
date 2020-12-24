<?php

namespace App\Controller;

use App\Entity\TipoDispositivo;
use App\Form\TipoDispositivoType;
use App\Repository\TipoDispositivoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipo/dispositivo")
 */
class TipoDispositivoController extends AbstractController
{
    /**
     * @Route("/", name="tipo_dispositivo_index", methods={"GET"})
     */
    public function index(TipoDispositivoRepository $tipoDispositivoRepository): Response
    {
        return $this->render('tipo_dispositivo/index.html.twig', [
            'tipo_dispositivos' => $tipoDispositivoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipo_dispositivo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipoDispositivo = new TipoDispositivo();
        $form = $this->createForm(TipoDispositivoType::class, $tipoDispositivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipoDispositivo);
            $entityManager->flush();

            return $this->redirectToRoute('tipo_dispositivo_index');
        }

        return $this->render('tipo_dispositivo/new.html.twig', [
            'tipo_dispositivo' => $tipoDispositivo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_dispositivo_show", methods={"GET"})
     */
    public function show(TipoDispositivo $tipoDispositivo): Response
    {
        return $this->render('tipo_dispositivo/show.html.twig', [
            'tipo_dispositivo' => $tipoDispositivo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipo_dispositivo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoDispositivo $tipoDispositivo): Response
    {
        $form = $this->createForm(TipoDispositivoType::class, $tipoDispositivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipo_dispositivo_index');
        }

        return $this->render('tipo_dispositivo/edit.html.twig', [
            'tipo_dispositivo' => $tipoDispositivo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_dispositivo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TipoDispositivo $tipoDispositivo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoDispositivo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tipoDispositivo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipo_dispositivo_index');
    }
}
