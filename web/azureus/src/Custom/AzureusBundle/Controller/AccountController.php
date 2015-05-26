<?php

// src/Acme/AccountBundle/Controller/AccountController.php
namespace Custom\AzureusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Custom\AzureusBundle\Form\RegistrationType;
use Custom\AzureusBundle\Form\Model\Registration;


class AccountController extends Controller
{
    public function registerAction()
    {
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('account_create'),
        ));

        return $this->render(
            'CustomAzureusBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }
    
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();

            $em->persist($registration->getUser());
            $em->flush();

            // Do redirecta home
            return $this->redirect();
        }

        return $this->render(
            'CustomAzureusBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }
}