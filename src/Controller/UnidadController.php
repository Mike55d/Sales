<?php

namespace App\Controller;

use App\Entity\Unidad;
use App\Form\UnidadType;
use App\Repository\UnidadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/unidad")
 */
class UnidadController extends AbstractController
{
	/**
	 * @Route("/", name="unidad_index", methods={"GET"})
	 */
	public function index(UnidadRepository $unidadRepository): Response
	{
		return $this->render('unidad/index.html.twig', [
			'unidads' => $unidadRepository->findAll(),
		]);
	}

	/**
	 * @Route("/new", name="unidad_new", methods={"GET","POST"})
	 */
	public function new(Request $request): Response
	{
		$unidad = new Unidad();
		$form = $this->createForm(UnidadType::class, $unidad);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($unidad);
			$entityManager->flush();

			return $this->redirectToRoute('unidad_index');
		}

		return $this->render('unidad/new.html.twig', [
			'unidad' => $unidad,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}/show", name="unidad_show", methods={"GET"})
	 */
	public function show(Unidad $unidad): Response
	{
		return $this->render('unidad/show.html.twig', [
			'unidad' => $unidad,
		]);
	}

	/**
	 * @Route("/{id}/edit", name="unidad_edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, Unidad $unidad): Response
	{
		$form = $this->createForm(UnidadType::class, $unidad);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('unidad_index');
		}

		return $this->render('unidad/edit.html.twig', [
			'unidad' => $unidad,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="unidad_delete", methods={"DELETE"})
	 */
	public function delete(Request $request, Unidad $unidad): Response
	{
		if ($this->isCsrfTokenValid('delete' . $unidad->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($unidad);
			$entityManager->flush();
		}

		return $this->redirectToRoute('unidad_index');
	}

	/**
	 * @Route("/getData", name="getData", methods={"POST","GET"})
	 */
	public function getData()
	{
		$em = $this->getDoctrine()->getManager();
		$unidades = $em->getRepository('App:Unidad')->findAll();
		$data = [];
		foreach ($unidades as $unidad) {
			$lineas = $em->getRepository('App:Linea')->findBy(['unidad' => $unidad]);
			$lineasFormated = [];
			foreach ($lineas as $linea) {
				$lineasFormated[] = [
					'id' => 'l' . $linea->getId(),
					'text' => $linea->getNumero(),
					'state' => ['opened' => false, 'selected' => false],
				];
			}
			$data[] = [
				'id' => $unidad->getId(),
				'text' => $unidad->getNombre(),
				'state' => ['opened' => false, 'selected' => false],
				'type' => 'root',
				'children' => $lineasFormated,
			];
		}

		$json = [
			'Simple root node',
			[
				'id' => 'node_2',
				'text' => 'Root node with options',
				'state' => ['opened' => true, 'selected' => true],
				'children' => [['text' => 'Child 1'], 'Child 2'],
				'type' => 'root'
			]
		];
		return new JsonResponse($data);
	}

	/**
	 * @Route("/changeLinea", name="changeLinea", methods={"POST","GET"})
	 */
	public function changeLinea(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$unidad = $em->getRepository('App:Unidad')->find($request->get('unidad'));
		$lineaIds = explode(',', str_replace('l', '', $request->get('lineas')));
		$lineas = $em->getRepository('App:Linea')->findBy(['id' => $lineaIds]);
		foreach ($lineas as $linea) {
			$linea->setUnidad($unidad);
			$em->flush();
		}
		return new JsonResponse('ok');
	}
}
