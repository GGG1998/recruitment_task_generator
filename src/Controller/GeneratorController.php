<?php
/**
 * Created by PhpStorm.
 * User: gabry
 * Date: 15.09.2018
 * Time: 13:22
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Utils\UniqueCode;
use App\Entity\Codes;

class GeneratorController extends AbstractController {

    /**
     * @Route("/code/create/", name="codes_create")
     * @param UniqueCode $uniqid
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function createCodes(UniqueCode $uniqid) {
        $codes = $uniqid->generateArray();
        $entity_manager = $this->getDoctrine()->getManager();

        foreach ($codes as $code) {
            $valid_code = $this->_createCodes($code['value'], $uniqid);
            $code_entity = new Codes($valid_code);
            $entity_manager->persist($code_entity);
            $entity_manager->flush();
        }

        return $this->render('codes/create.html.twig', [
            'codes' => $codes,
        ]);
    }

    /**
     * @Route("/", name="codes_list")
     */
    public function listCodes() {
        $codes_repo = $this->getDoctrine()->getRepository(Codes::class);
        $codes = $codes_repo->findAll();

        return $this->render('codes/list.html.twig', [
            'codes' => $codes
        ]);
    }

    /**
     * @Route("/code/remove/", name="codes_remove")
     * @param Request $request
     * @param UniqueCode $uniqid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeCodes(Request $request, UniqueCode $uniqid) {
        $codes= new Codes();
        $form = $this->createFormBuilder($codes)
            ->add('value', TextareaType::class, array('label' => 'Kody'))
            ->add('save', SubmitType::class, array('label' => 'Usuń kody'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $list_codes = $form->get('value')->getData();
            $list_codes = $uniqid->parse($list_codes);
            $this->_removeCodes($list_codes);
        }
        return $this->render('codes/remove.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @param $codes
     * @return array
     */
    private function _removeCodes($codes) {
        $list_codes = [];
        $manager = $this->getDoctrine()->getManager();

        // TODO make more optimal: use $manager->createQueryBuilder and WHERE IN (code1, code2)
        foreach ($codes as $search_code) {
            $code = $manager->getRepository(Codes::class)->findOneBy(
                ['value' => $search_code]
            );
            if (!$code) {
                throw $this->createNotFoundException(
                    'No product found for code: '.$search_code
                );
            }
            $manager->remove($code);
            $manager->flush();
        }
        return $list_codes;
    }

    /**
     * Generate new key to time when code will be unique
     * @param $code
     * @param UniqueCode $uniqid
     * @return mixed
     * @throws \Exception
     */
    private function _createCodes($code, UniqueCode $uniqid) {
        $manager = $this->getDoctrine()->getManager();
        $is_exist = $manager->getRepository(Codes::class)->findOneBy(
            ['value' => $code]
        );
        if(!$is_exist)
            return $code;
        else
            $this->_createCodes($uniqid->real(), $uniqid);
    }
}