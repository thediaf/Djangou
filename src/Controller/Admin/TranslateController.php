<?php

namespace App\Controller\Admin;

use App\Repository\LanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TranslateController extends AbstractController
{
    /**
     * @Route("/admin/translate", name="admin_translate")
     */
    public function index(Request $request, LanguageRepository $languageRepository)
    {
        return $this->render('admin/translate/index.html.twig', [
            'languages' => $languageRepository->findAll(),
        ]);
    }
}
