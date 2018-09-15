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

class GeneratorController extends AbstractController {

    /**
     * @Route("/code/create/", name="codes_create")
     * @param UniqueCode $uniqid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createCodes(UniqueCode $uniqid) {
        $codes = $uniqid->generateArray();

        return $this->render('codes/create.html.twig', [
            'codes' => $codes,
        ]);
    }

    /**
     * @Route("/", name="codes_list")
     */
    public function listCodes() {
        return $this->render('codes/list.html.twig');
    }

    /**
     * @Route("/code/remove/", name="codes_remove")
     */
    public function removeCodes() {
        return $this->render('codes/remove.html.twig');
    }
}