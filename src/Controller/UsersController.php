<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("users", name="user_")
 */
class UsersController extends AbstractController
{
	/**
	 * @Route("/", name="index")
	 */
	public function index(UserRepository $userRepo): Response
	{
		return $this->render('user/index.html.twig', [
			'users' => $userRepo->findAll(),
		]);
	}
	/**
	 * @Route("/new", name="new", methods={"GET","POST"})
	 */
	public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
	{
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$user->setPassword(
				$passwordEncoder->encodePassword(
					$user,
					$user->getPassword()
				)
			);
			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('user_index');
		}

		return $this->render('user/new.html.twig', [
			'user' => $user,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
	{
		$form = $this->createForm(UserEditType::class, $user);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$userEdit = $request->get('user_edit');
			$password = $userEdit['password']['first'];
			if ($password)
				$user->setPassword(
					$passwordEncoder->encodePassword(
						$user,
						$password
					)
				);
			$this->getDoctrine()->getManager()->flush();
			return $this->redirectToRoute('user_index');
		}
		return $this->render('user/edit.html.twig', [
			'user' => $user,
			'form' => $form->createView(),
		]);
	}

	
	/**
	 * @Route("/{id}", name="show", methods={"GET"})
	 */
	public function show(User $user): Response
	{
		return $this->render('user/show.html.twig', [
			'user' => $user,
		]);
	}

	/**
	 * @Route("/{id}", name="delete", methods={"DELETE"})
	 */
	public function delete(Request $request, User $user): Response
	{
		if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($user);
			$entityManager->flush();
		}
		return $this->redirectToRoute('user_index');
	}

}
