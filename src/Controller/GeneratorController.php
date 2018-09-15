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

class GeneratorController extends AbstractController {

    /**
     * @Route("/code/create/", name="codes_create")
     */
    public function createCodes() {
        $number = random_int(0, 100);

        return $this->render('codes/create.html.twig', [
            'number' => $number,
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