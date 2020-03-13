<?php

namespace App\Controller\Admin;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index(UsersRepository $usersRepository)
    {
        return $this->render('admin/home/index.html.twig', [
            'users' => $usersRepository->getUsersCount(),
        ]);
    }
}
