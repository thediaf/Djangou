<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="admin_users")
     */
    public function index(UsersRepository $usersRepository)
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="admin_show")
     */
    public function show(Users $user)
    {
        return $this->render('admin/user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
