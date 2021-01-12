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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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
				$icon = 'icons/phoneIcon.png';
				$extra = '';
				if ($linea->getTipo()->getTipo() == 'Modem') {
					$icon = 'icons/modemIcon.png';
					$extra = '(Modem)';
				}
				if ($linea->getTipo()->getTipo() == 'Celular' && $linea->getInternet()) {
					$icon = 'icons/wifiIcon.png';
					$extra = '(Dados)';
				}
				$user = $linea->getUserLinea() ? $linea->getUserLinea()->getNombre() : '';
				if (!$user) {
					$icon = 'icons/noUser.png';
				}
				$lineasFormated[] = [
					'id' => 'l' . $linea->getId(),
					'text' => $user . ' - Tel:(' . $linea->getDdd() . ')' . $linea->getNumero() .$extra,
					'state' => ['opened' => false, 'selected' => false],
					'icon' => $icon
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

	/**
	 * @Route("/getUnidad", name="getUnidad", methods={"POST","GET"})
	 */
	public function getUnidad(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$unidad = $em->getRepository('App:Unidad')->find($request->get('id'));
		$encoders = [new XmlEncoder(), new JsonEncoder()];
		$normalizers = [new ObjectNormalizer()];
		$serializer = new Serializer($normalizers, $encoders);
		$jsonContent = $serializer->serialize($unidad, 'json');
		return new JsonResponse($jsonContent);
	}

	/**
	 * @Route("/editUnidadApi", name="editUnidadApi", methods={"POST","GET"})
	 */
	public function editUnidadApi(Request $request, UnidadRepository $unidadRepo)
	{
		$em = $this->getDoctrine()->getManager();
		$asociacion = $em->getRepository('App:Asociacion')->find($request->get('asociacion'));
		$unidad = $unidadRepo->find($request->get('id'));
		$unidad->setNumero($request->get('numero'));
		$unidad->setNombre($request->get('nombre'));
		$unidad->setEncargado($request->get('encargado'));
		$unidad->setEmailEncargado($request->get('email'));
		$unidad->setEndereso($request->get('endereso'));
		$unidad->setAsociacion($asociacion);
		$unidad->setCiudad($request->get('ciudad'));
		$unidad->setActiva($request->get('active') ? 1 : 0);
		$unidad->setEmailDetallado($request->get('emailDetallado') ? 1 : 0);
		$em->flush();
		return new JsonResponse('ok');
	}
}
