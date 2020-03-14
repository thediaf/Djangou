<?php

namespace App\Controller;

use App\Entity\Search;
use App\Event\TranslateEvent;
use App\Event\TranslateEvents;
use App\Form\SearchType;
use App\Repository\TranslateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    /**
     * @Route("/", name="translation")
     */
    public function index(TranslateRepository $translateRepository, Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if($request->isXmlHttpRequest()) {
            $translated = $translateRepository->getTranslationOf($search);

            if($translated) {
                foreach ($translated->getAll() as $source) {
                    $event = new TranslateEvent($source, $translated);
                    $eventDispatcher->dispatch($event, TranslateEvents::TRANSLATE_REQUESTED);
                    break;
                }
            }

            return $this->json($translated);
        }

        return $this->render('translation/index.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}
