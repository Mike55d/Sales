<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusquedaController extends AbstractController
{
	/**
	 * @Route("/busqueda", name="busqueda")
	 */
	public function index(): Response
	{
		$em = $this->getDoctrine()->getManager();
		$lineas = $em->getRepository('App:Linea')->findAll();
		$unidades = $em->getRepository('App:Unidad')->findAll();
		$users = $em->getRepository('App:UserLinea')->findAll();
		return $this->render('busqueda/index.html.twig', [
			'lineas' => $lineas,
			'unidades' => $unidades,
			'users' => $users,
		]);
	}
}
