<?php

namespace Custom\AzureusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        // zrobic tutaj jak http://stackoverflow.com/a/25621040/3978701
        $arts = $em->getRepository('CustomAzureusBundle:Art')->findBy([], ['date' => 'DESC']);
        return $this->render('CustomAzureusBundle:Default:index.html.twig', array (
            'arts'=>$arts
        ));
        
        return $this->render('CustomAzureusBundle:Default:index.html.twig');
    }
    
    public function succesAction() {
        return $this->render('CustomAzureusBundle:Default:succes.html.twig');
    }
}
