<?php

namespace App\Controller;

use App\Entity\History;
use App\Form\HistoryType;
use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/history")
 */
class HistoryController extends AbstractController
{
    /**
     * @Route("/", name="history_index", methods={"GET"})
     */
    public function index(HistoryRepository $historyRepository): Response
    {
        return $this->render('history/index.html.twig', [
            'histories' => $historyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="history_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $history = new History();
        $form = $this->createForm(HistoryType::class, $history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($history);
            $entityManager->flush();

            return $this->redirectToRoute('history_index');
        }

        return $this->render('history/new.html.twig', [
            'history' => $history,
            'form' => $form->createView(),
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
     * @Route("/{id}/edit", name="history_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, History $history): Response
    {
        $form = $this->createForm(HistoryType::class, $history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('history_index');
        }

        return $this->render('history/edit.html.twig', [
            'history' => $history,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="history_delete", methods={"DELETE"})
     */
    public function delete(Request $request, History $history): Response
    {
        if ($this->isCsrfTokenValid('delete'.$history->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($history);
            $entityManager->flush();
        }

        return $this->redirectToRoute('history_index');
    }
}
