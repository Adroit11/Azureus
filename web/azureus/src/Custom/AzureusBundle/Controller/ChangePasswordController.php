<?php
namespace Custom\AzureusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Custom\AzureusBundle\Form\ChangePasswordType;
use Custom\AzureusBundle\Form\Model\ChangePassword;

class ChangePasswordController extends Controller
{
    public function changePasswdAction(Request $request)
    {
      $changePasswordModel = new ChangePassword();
      $form = $this->createForm(new ChangePasswordType(), $changePasswordModel);
      $form->add('submit', 'submit', array('label' => 'Change'));

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $entity = $this->getUser();
          $password = $form->get('newPassword')->getData();
          $entity->setPassword($password);
          $em->flush();
          // such as encoding with MessageDigestPasswordEncoder and persist
          return $this->redirect($this->generateUrl('change_passwd_success'));
      }

      return $this->render('CustomAzureusBundle:Miscellaneous:changePasswd.html.twig', array(
          'form' => $form->createView(),
      ));      
    }
}