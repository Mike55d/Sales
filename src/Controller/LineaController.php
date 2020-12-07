<?php

namespace App\Controller;

use App\Entity\Linea;
use App\Form\LineaType;
use App\Repository\LineaRepository;
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
	 * @Route("/{id}/del", name="linea_delete", methods={"DELETE"})
	 */
	public function delete(Request $request, Linea $linea): Response
	{
		if ($this->isCsrfTokenValid('delete' . $linea->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($linea);
			$entityManager->flush();
		}

		return $this->redirectToRoute('linea_index');
	}

		/**
	 * @Route("/{id}/delApi", name="linea_deleteApi", methods={"DELETE"})
	 */
	public function deleteApi(Request $request, Linea $linea): Response
	{
		if ($this->isCsrfTokenValid('delete' . $linea->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($linea);
			$entityManager->flush();
		}
		return new JsonResponse('ok');

	}

	/**
	 * @Route("/getApi", name="linea_get", methods={"POST"})
	 */
	public function getLinea(LineaRepository $lineaRepository , Request $request): Response
	{
		$linea = $lineaRepository->find($request->get('id'));
		$encoders = [new XmlEncoder(), new JsonEncoder()];
		$normalizers = [new ObjectNormalizer()];
		$serializer = new Serializer($normalizers, $encoders);
		$jsonContent = $serializer->serialize($linea, 'json');
		return new JsonResponse($jsonContent);
	}

	/**
	 * @Route("/newApi", name="linea_newApi", methods={"GET","POST"})
	 */
	public function newApi(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$linea = new Linea();
		$unidad = $em->getRepository('App:Unidad')->find($request->get('unidad'));
		$linea->setNumero($request->get('numero'));
		$linea->setOperadora($request->get('operadora'));
		$linea->setChip($request->get('chip'));
		$linea->setTipo($request->get('tipo'));
		$linea->setUnidad($unidad);
		$em->persist($linea);
		$em->flush();
		$lineaFormated = ['id' => 'l' . $linea->getId(),
		'text' => $linea->getNumero(),
		'state' => ['opened' => false, 'selected' => false]];
		return new JsonResponse($lineaFormated);
	}


	/**
	 * @Route("/editApi", name="linea_editApi", methods={"POST"})
	 */
	public function editLineaApi(LineaRepository $lineaRepository , Request $request): Response
	{
		$linea = $lineaRepository->find($request->get('id'));
		$linea->setNumero($request->get('numero'));
		$linea->setOperadora($request->get('operadora'));
		$linea->setChip($request->get('chip'));
		$linea->setTipo($request->get('tipo'));
		$em = $this->getDoctrine()->getManager();
		$em->flush();
		return new JsonResponse('ok');
	}
}
