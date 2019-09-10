<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Massfice\SessionUtils\SessionUtils;

class InitController extends AbstractController
{
    /**
     * @Route("/{action}", name="init")
     */
    public function init(string $action = '')
    {

        SessionUtils::advancedStore('init_shelf','b',true);

        return $this->render('index.html.twig',[
          'action' => $action
        ]);
    }
}
