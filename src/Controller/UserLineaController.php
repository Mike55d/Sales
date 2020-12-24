<?php

namespace App\Controller;

use App\Entity\UserLinea;
use App\Form\UserLineaType;
use App\Repository\UserLineaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/linea")
 */
class UserLineaController extends AbstractController
{
    /**
     * @Route("/", name="user_linea_index", methods={"GET"})
     */
    public function index(UserLineaRepository $userLineaRepository): Response
    {
        return $this->render('user_linea/index.html.twig', [
            'user_lineas' => $userLineaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_linea_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userLinea = new UserLinea();
        $form = $this->createForm(UserLineaType::class, $userLinea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userLinea);
            $entityManager->flush();

            return $this->redirectToRoute('user_linea_index');
        }

        return $this->render('user_linea/new.html.twig', [
            'user_linea' => $userLinea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_linea_show", methods={"GET"})
     */
    public function show(UserLinea $userLinea): Response
    {
        return $this->render('user_linea/show.html.twig', [
            'user_linea' => $userLinea,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_linea_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserLinea $userLinea): Response
    {
        $form = $this->createForm(UserLineaType::class, $userLinea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_linea_index');
        }

        return $this->render('user_linea/edit.html.twig', [
            'user_linea' => $userLinea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_linea_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserLinea $userLinea): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userLinea->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userLinea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_linea_index');
    }
}
