<?php
/**
 * Created by PhpStorm.
 * User: gabry
 * Date: 15.09.2018
 * Time: 13:22
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
            $code_entity = new Codes($code['value']);
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
     */
    public function removeCodes() {
        return $this->render('codes/remove.html.twig');
    }
}