<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\LanguageRepository;
use App\Repository\TranslateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    /**
     * @Route("/", name="translation")
     */
    public function index(TranslateRepository $translateRepository, Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        // $translation = $translateRepository->findAll();
        return $this->render('translation/index.html.twig', [
            'controller_name' => 'TranslationController',
            'wordTranslate' => $translateRepository->getTranslationOf($search),
            'form'  => $form->createView()
        ]);
    }
}
