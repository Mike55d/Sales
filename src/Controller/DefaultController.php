<?php

namespace App\Controller;

use App\Entity\Linea;
use App\Entity\Unidad;
use App\Entity\UserLinea;
use App\Repository\LineaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Faker\Factory;


class DefaultController extends AbstractController
{
	/**
	 * @Route("/", name="default")
	 */
	public function index(LineaRepository $lineaRepo): Response
	{
		$em = $this->getDoctrine()->getManager();
		$tipos = $em->getRepository('App:TipoDispositivo')->findAll();
		$operadoras = $em->getRepository('App:Operadora')->findAll();
		$asociaciones = $em->getRepository('App:Asociacion')->findAll();
		$totalLineas = $lineaRepo->getTotalRecords();
		$internet = $lineaRepo->getTotalRecords('internet');
		$telefono = $lineaRepo->getTotalRecords('telefono');
		$modem = $lineaRepo->getTotalRecords('modem');
		$usersLinea = $em->getRepository('App:UserLinea')->findAll();
		return $this->render('default/index.html.twig', [
			'tipos'=> $tipos,
			'operadoras' => $operadoras,
			'totalLineas' => $totalLineas,
			'internet' => $internet,
			'modem' => $modem,
			'telefono' => $telefono,
			'asociaciones' => $asociaciones,
			'users' => $usersLinea
		]);
	}

	/**
	 * @Route("/fakeUnidades", name="fakeUnidades")
	 */
	public function fakeUnidades()
	{
		$em = $this->getDoctrine()->getManager();
		$faker = Factory::create();
		for ($i=0; $i < 100; $i++) {
			$rand = rand(1,2);
			$asociacion = $em->getRepository('App:Asociacion')->find($rand);
			$unidad = new Unidad;
			$unidad->setNombre($faker->name());
			$unidad->setNumero($faker->phoneNumber);
			$unidad->setEncargado($faker->name());
			$unidad->setEmailEncargado($faker->email);
			$unidad->setEndereso($faker->name());
			$unidad->setActiva(1);
			$unidad->setCiudad($faker->city);
			$unidad->setEmailDetallado(1);
			$unidad->setAsociacion($asociacion);
			$em->persist($unidad);
			$em->flush();
		}
		return new JsonResponse('datos creados');

	}

	/**
	 * @Route("/fakeUsuarios", name="fakeUsuarios")
	 */
	public function fakeUsuarios()
	{
		$em = $this->getDoctrine()->getManager();
		$faker = Factory::create();
		for ($i=0; $i < 250; $i++) {
			$userLinea = new UserLinea;
			$userLinea->setNombre($faker->name());
			$userLinea->setTelefono($faker->phoneNumber);
			$userLinea->setEmail($faker->email);
			$userLinea->setOrden('Orden I');
			$userLinea->setActive(1);
			$em->persist($userLinea);
			$em->flush();
		}
		return new JsonResponse('usuarios creados');

	}

		/**
	 * @Route("/fakeLineas", name="fakeLineas")
	 */
	public function fakeLineas()
	{
		$em = $this->getDoctrine()->getManager();
		$faker = Factory::create();
		$unidades = $em->getRepository('App:Unidad')->findAll();
		$usersLinea = $em->getRepository('App:UserLinea')->findAll();
		for ($i=0; $i < 250; $i++) {
			$rand = rand(100,999);
			$rand2 = rand(1,2);
			$rand3 = rand(10000,99999);
			$rand4 = rand(0, count($unidades) -1 );
			$rand5 = rand(0,1);
			$rand6 = rand(0,count($usersLinea) -1 );
			$operadora = $em->getRepository('App:Operadora')->find($rand2);
			$tipo = $em->getRepository('App:TipoDispositivo')->find($rand2);
			$linea = new Linea;
			$linea->setDdd($rand);
			$linea->setNumero($faker->phoneNumber);
			$linea->setOperadora($operadora);
			$linea->setChip($rand3);
			$linea->setSerie($rand3);
			$linea->setObservaciones('ninguna');
			$linea->setTipo($tipo);
			$linea->setOperadora($operadora);
			$linea->setUnidad($unidades[$rand4]);
			$linea->setActive(1);
			$linea->setInternet($rand5);
			$linea->setUserLinea($usersLinea[$rand6]);
			$em->persist($linea);
			$em->flush();
		}
		return new JsonResponse('lineas creadas');
	}

}
