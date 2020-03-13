<?php

namespace App\Controller\Admin;

use App\Entity\Language;
use App\Form\Admin\LanguageType;
use App\Repository\LanguageRepository;
use App\Repository\TranslateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslateController extends AbstractController
{
    /**
     * @Route("/translate", name="admin_translate")
     */
    public function index(LanguageRepository $languageRepository)
    {
        return $this->render('admin/translate/index.html.twig', [
            'languages' => $languageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/translate/add-lang", name="admin_add_lang", methods={"POST"})
     */
    public function addLanguage(Request $request, EntityManagerInterface $entityManager): Response
    {
        sleep(3);
        if($request->isXmlHttpRequest()) {
            $langName = $request->request->get('lang');

            $definedLang = $entityManager->getRepository(Language::class)->findBy(['name' => $langName]);

            if($definedLang) {
                return $this->json([
                    'type' => 'error',
                    'message' => 'Cette langue exite déjà'
                ]);
            }

            $language = (new Language())->setName($langName);

            $entityManager->persist($language);
            $entityManager->flush();

            return $this->json([
                'type' => 'success',
                'message' => 'La langue a été ajoutée avec succès.',
                'lang' => $language,
                'url' => $this->generateUrl('admin_translation_list', ['id' => $language->getId()])
            ]);
        }
        
        throw new \Exception("Should never be executed");
    }

    /**
     * @Route("/translate/{id}", name="admin_translation_list")
     */
    public function translationList(Request $request, Language $language, TranslateRepository $translateRepository)
    {
        return $this->render('admin/translate/list.html.twig', [
            'lang' => $language,
            'translates' => $translateRepository->paginateByLanguage($language, $request->query->get('page', 1))
        ]);
    }
}
