<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
	/**
	 * @Route("/", name="default")
	 */
	public function index(): Response
	{
		$em = $this->getDoctrine()->getManager();
		$unidades = $em->getRepository('App:Unidad')->findAll();
		$data = [];
		foreach ($unidades as $unidad) {
			$lineas = $em->getRepository('App:Linea')->findBy(['unidad'=> $unidad]);
			$data[]=['unidad'=> $unidad , 'lineas'=> $lineas];
		}
		return $this->render('default/index.html.twig', [
			'data' => $data,
		]);
	}
}
