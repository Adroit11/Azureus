<?php

namespace Custom\AzureusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        // Loading last 50 arts
        // TODO ajax load on scrolling
        $arts = $em->getRepository('CustomAzureusBundle:Art')->findBy([], ['date' => 'DESC'], 50);
        return $this->render('CustomAzureusBundle:Default:index.html.twig', array (
            'arts'=>$arts
        ));
    }
    
    public function succesAction() {
        return $this->render('CustomAzureusBundle:Default:succes.html.twig');
    }
}
