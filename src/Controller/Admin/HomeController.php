<?php

namespace App\Controller\Admin;

use App\Repository\LanguageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index(UserRepository $usersRepository, LanguageRepository $languageRepository)
    {
        return $this->render('admin/home/index.html.twig', [
            'users_count' => $usersRepository->getUsersCount(),
            'languages_count' => $languageRepository->getLanguagesCount(),
        ]);
    }
}
