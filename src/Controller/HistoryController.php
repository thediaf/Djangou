<?php

/*
 * This file is part of the Djangou application.
 *
 * (c) Diafra Soumaré and Bechir Ba
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\History;
use App\Repository\HistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/history")
 * @IsGranted("ROLE_USER")
 */
class HistoryController extends AbstractController
{
    /**
     * @Route("/", name="history_index", methods={"GET"})
     */
    public function index(HistoryRepository $historyRepository, UserInterface $user): Response
    {
        return $this->render('history/index.html.twig', [
            'histories' => $historyRepository->findBy(['user' => $user]),
        ]);
    }

    /**
     * @Route("/{id}", name="history_show", methods={"GET"})
     */
    public function show(History $history): Response
    {
        return $this->render('history/show.html.twig', [
            'history' => $history,
        ]);
    }

    /**
     * @Route("/{id}/update-status", name="history_update_status", methods={"POST"})
     */
    public function updateStatus(History $history, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$request->isXmlHttpRequest()) {
            throw new \Exception('This action support only ajax request');
        }

        $isMemorized = $request->request->get('isMemorized', null);

        if (null === $isMemorized) {
            return $this->json([
                'success' => false,
            ]);
        }

        $history->setIsMemorised('false' == $isMemorized ? false : true);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'progression' => $this->getUser()->getProgression(),
        ]);
    }

    /**
     * @Route("/{id}", name="history_delete", methods={"DELETE"})
     */
    public function delete(Request $request, History $history): Response
    {
        if ($this->isCsrfTokenValid('delete' . $history->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($history);
            $entityManager->flush();
        }

        return $this->redirectToRoute('history_index');
    }
}
