<?php

namespace Custom\AzureusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CustomAzureusBundle:Default:index.html.twig');
    }
}
