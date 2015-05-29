<?php

namespace Custom\AzureusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Custom\AzureusBundle\Entity\User;
use Custom\AzureusBundle\Entity\UserInfo;
use Custom\AzureusBundle\Form\UserType;
use Custom\AzureusBundle\Form\UserEditType;

/**
 * User controller.
 *
 */
class UserController extends Controller {

    /**
     * Lists all User entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CustomAzureusBundle:User')->findAll();

        return $this->render('CustomAzureusBundle:User:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new User entity.
     * 
     */
    public function createAction(Request $request) {
        $entity = new User();
        $user_info = new UserInfo();
        $entity->setInfo($user_info);
        $user_info->setOwner($entity);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->persist($user_info);
            $em->flush();

            $securityContext = $this->container->get('security.context');
            if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                return $this->redirect($this->generateUrl('admin_user_show', array('id' => $entity->getId())));
            }
            else {
                return $this->redirect($this->generateUrl('user_created'));
            }
        }


        return $this->render('CustomAzureusBundle:User:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity) {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('admin_user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction() {
        $entity = new User();
        $form = $this->createCreateForm($entity);

        return $this->render('CustomAzureusBundle:User:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CustomAzureusBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CustomAzureusBundle:User:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Finds and displays a User entity accesable for everyone.
     * Displays last arts, last posts and basic info about user
     */
    public function showProfileAction($username) {
        $em = $this->getDoctrine()->getManager();

        // Criteria for last 50 arts/posts from defined user
        $user_criteria = array('username' => $username);
        $user = $em->getRepository('CustomAzureusBundle:User')->findOneBy($user_criteria);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        } else {
            $arts_criteria = array('owner' => $user->getId());
            $arts = $em->getRepository('CustomAzureusBundle:Art')->findBy($arts_criteria, ['date' => 'DESC'], 2);
            $posts = $em->getRepository('CustomAzureusBundle:Post')->findBy($arts_criteria, ['date' => 'DESC'], 2);
            $comments = $em->getRepository('CustomAzureusBundle:ArtComment')->findBy($arts_criteria, ['date' => 'DESC'], 5);

            return $this->render('CustomAzureusBundle:User:profile.html.twig', array(
                        'user' => $user,
                        'arts' => $arts,
                        'posts'=> $posts,
                        'comments'=> $comments
            ));
        }
    }
    
    
    /**
     * Find and displays all arts from User
     */
    public function showGalleryAction($username) {
        $em = $this->getDoctrine()->getManager();

        // Criteria for last 50 arts from defined user
        // To do load by scroll by ajax
        $user_criteria = array('username' => $username);
        $user = $em->getRepository('CustomAzureusBundle:User')->findOneBy($user_criteria);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        } else {
            $arts_criteria = array('owner' => $user->getId());
            $arts = $em->getRepository('CustomAzureusBundle:Art')->findBy($arts_criteria, ['date' => 'DESC'], 50);

            return $this->render('CustomAzureusBundle:User:gallery.html.twig', array(
                        'user' => $user,
                        'arts' => $arts,
            ));
        }
    }
    
        
    /**
     * Find and displays all posts from User
     */
    public function showJournalAction($username) {
        $em = $this->getDoctrine()->getManager();

        // Criteria for last 50 posts from defined user
        // To do load by scroll by ajax
        $user_criteria = array('username' => $username);
        $user = $em->getRepository('CustomAzureusBundle:User')->findOneBy($user_criteria);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        } else {
            $arts_criteria = array('owner' => $user->getId());
            $posts = $em->getRepository('CustomAzureusBundle:Post')->findBy($arts_criteria, ['date' => 'DESC'], 50);

            return $this->render('CustomAzureusBundle:User:journal.html.twig', array(
                        'user' => $user,
                        'posts' => $posts,
            ));
        }
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CustomAzureusBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CustomAzureusBundle:User:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editProfileAction() {

        $user_id = $this->get('security.context')->getToken()->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CustomAzureusBundle:User')->find($user_id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($user_id);

        return $this->render('CustomAzureusBundle:User:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity) {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(new UserType(), $entity, array(
                'action' => $this->generateUrl('admin_user_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));
        } else {
             $form = $this->createForm(new UserEditType(), $entity, array(
                'action' => $this->generateUrl('profile_update'),
                'method' => 'PUT',
            ));
        }

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CustomAzureusBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_user_edit', array('id' => $id)));
        }

        return $this->render('CustomAzureusBundle:User:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Edits an existing User entity.
     *
     */
    public function profileUpdateAction(Request $request) {
        $id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CustomAzureusBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('profile_edit'));
        }

        return $this->render('CustomAzureusBundle:User:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CustomAzureusBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_user_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
