<?php

/*
 * This file is part of the Djangou application.
 *
 * (c) Diafra Soumaré and Bechir Ba
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Suggestion;
use App\Repository\SuggestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SuggestionController extends AbstractController
{
    /**
     * @Route("/suggestions", name="admin_suggestions")
     */
    public function index(SuggestionRepository $suggestionsRepository)
    {
        return $this->render('admin/suggestion/index.html.twig', [
            'suggestions' => $suggestionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/suggestion/{id}", name="admin_suggestion_show")
     */
    public function show(Suggestion $suggestion)
    {
        return $this->render('admin/suggestion/show.html.twig', [
            'suggestion' => $suggestion,
        ]);
    }
}
