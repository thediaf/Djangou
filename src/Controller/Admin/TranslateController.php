<?php

namespace App\Controller\Admin;

use App\Entity\Language;
use App\Entity\Translate;
use App\Form\Admin\TranslateType;
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
        sleep(1); // TODO: remove after tests.
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
     * @Route("/translate/{id}/add", name="admin_translate_add")
     */
    public function translateAdd(Request $request, Language $language, EntityManagerInterface $entityManager)
    {
        // sleep(1); // TODO: remove after tests.
        // if(!$request->isXmlHttpRequest()) {
        //     throw new \Exception("This method accept only AJAX reuqest");
        // }

        $translate = new Translate();
        $form = $this->createForm(TranslateType::class, $translate, [
            'source_language' => $language->getName()
        ]);
        $form->handleRequest($request);

        if($request->isMethod('POST')) {
            if($form->isSubmitted() && $form->isValid()) {

                foreach ($translate->getTranslates() as $tr) {
                    $translated = (new Translate())
                        ->setWord($tr->getWord())
                        ->setLanguage($tr->getLanguage())
                        ->setClasse($tr->getClasse());
                    $translate->addTranslate($translated);

                    $translate->removeTranslate($tr);

                    $entityManager->persist($translated);
                }
                $translate->setLanguage($language);
                $entityManager->persist($translate);
                $entityManager->flush();

                return $this->json('success');
            }
        }

        return $this->render('admin/translate/_translate_form.html.twig', [
            'form' => $form->createView(),
            'lang' => $language
        ]);
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
