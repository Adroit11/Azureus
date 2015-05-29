<?php

namespace Custom\AzureusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Custom\AzureusBundle\Entity\Art;
use Custom\AzureusBundle\Form\ArtType;

use Custom\AzureusBundle\Entity\ArtComment;
use Custom\AzureusBundle\Entity\Comment;
use Custom\AzureusBundle\Form\CommentType;

/**
 * Art controller.
 *
 */
class ArtController extends Controller {

    /**
     * Lists all Art entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();


        // If we are not an admin then load all of our arts
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $criteria = array('owner' => $this->getUser()->getId());
            $entities = $em->getRepository('CustomAzureusBundle:Art')->findBy($criteria);
        } else {
            $entities = $em->getRepository('CustomAzureusBundle:Art')->findAll();
        }

        return $this->render('CustomAzureusBundle:Art:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Art entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Art();
        $form = $this->createCreateForm($entity, array('is_admin' => $this->get('security.context')->isGranted('ROLE_ADMIN')));
        $form->handleRequest($request);
        if ($form->isValid()) {
            // If we aren't admin then set us as an owner
            if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $entity->setOwner($this->get('security.context')->getToken()->getUser());
            }

            $em = $this->getDoctrine()->getManager();
            $entity->upload();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('art_show', array('id' => $entity->getId())));
        }
        return $this->render('CustomAzureusBundle:Art:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Art entity.
     *
     * @param Art $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Art $entity) {
        $form = $this->createForm(new ArtType(), $entity, array(
            'action' => $this->generateUrl('art_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * Displays a form to create a new Art entity.
     *
     */
    public function newAction() {
        $entity = new Art();
        $form = $this->createCreateForm($entity);
        return $this->render('CustomAzureusBundle:Art:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Art entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CustomAzureusBundle:Art')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Art entity.');
        }
        
        $comments_criteria = array('parent' => $entity->getId());
        $comments = $em->getRepository('CustomAzureusBundle:ArtComment')->findBy($comments_criteria, ['date' => 'DESC'], 5);
            
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('CustomAzureusBundle:Art:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                    'comments' => $comments,
        ));
    }

    /**
     * Displays a form to edit an existing Art entity.
     *
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CustomAzureusBundle:Art')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Art entity.');
            return $this->render('CustomAzureusBundle:Fun:ydtmw.html.twig');
        }

        // TODO change this if statement to something more clear
        if ($entity->getOwner()) {
            if ($this->getUser()->getId() === $entity->getOwner()->getId() OR $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $editForm = $this->createEditForm($entity);
                $deleteForm = $this->createDeleteForm($id);
                return $this->render('CustomAzureusBundle:Art:edit.html.twig', array(
                            'entity' => $entity,
                            'edit_form' => $editForm->createView(),
                            'delete_form' => $deleteForm->createView(),
                ));
            } else {
                throw $this->createNotFoundException('Unsufficent permission.');
                return $this->render('CustomAzureusBundle:Fun:ydtmw.html.twig');
            }
        } else {
            throw $this->createNotFoundException('Unsufficent permission.');
            return $this->render('CustomAzureusBundle:Fun:ydtmw.html.twig');
        }
    }

    /**
     * Creates a form to edit a Art entity.
     *
     * @param Art $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Art $entity) {
        if ($entity->getOwner()) {
            if ($this->getUser()->getId() === $entity->getOwner()->getId() OR $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(new ArtType(), $entity, array(
                    'action' => $this->generateUrl('art_update', array('id' => $entity->getId())),
                    'method' => 'PUT',
                ));
                $form->add('submit', 'submit', array('label' => 'Update'));
                return $form;
            }
        } else {
            throw $this->createNotFoundException('Unsufficent permission.');
            return $this->render('CustomAzureusBundle:Fun:ydtmw.html.twig');
        }
    }

    /**
     * Edits an existing Art entity.
     *
     */
    public function updateAction(Request $request, $id) {
        if ($entity->getOwner()) {
            if ($this->getUser()->getId() === $entity->getOwner()->getId() OR $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('CustomAzureusBundle:Art')->find($id);
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Art entity.');
                }
                $deleteForm = $this->createDeleteForm($id);
                $editForm = $this->createEditForm($entity);
                $editForm->handleRequest($request);
                if ($editForm->isValid()) {
                    $em->flush();
                    return $this->redirect($this->generateUrl('art_edit', array('id' => $id)));
                }
                return $this->render('CustomAzureusBundle:Art:edit.html.twig', array(
                            'entity' => $entity,
                            'edit_form' => $editForm->createView(),
                            'delete_form' => $deleteForm->createView(),
                ));
            } else {
                throw $this->createNotFoundException('Unsufficent permission.');
            }
        }
    }

    /**
     * Deletes a Art entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CustomAzureusBundle:Art')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Art entity.');
            }
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('art'));
    }

    /**
     * Creates a form to delete a Art entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('art_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    
    /**
     * Creates a new Art entity.
     *
     */
    public function createCommentAction(Request $request, $art_id) {
        $entity = new ArtComment();
        $form = $this->createCommentCreateForm($entity, array('art_id' => $art_id, 'is_admin' => $this->get('security.context')->isGranted('ROLE_ADMIN')));
        $form->handleRequest($request);
        if ($form->isValid()) {
            // If we aren't admin then set us as an owner
            if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $entity->setOwner($this->get('security.context')->getToken()->getUser());
            }
            
            $em = $this->getDoctrine()->getManager();

            $parent = $em->getRepository('CustomAzureusBundle:Art')->find($art_id);
            $entity->setParent($parent);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('art_show', array('id' => $art_id)));
        }
        
        // To zmienic
        return $this->render('CustomAzureusBundle:Comment:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Art entity.
     *
     * @param Art $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCommentCreateForm(ArtComment $entity, $options) {
        $form = $this->createForm(new CommentType(), $entity, array(
            'action' => $this->generateUrl('art_comment_create', array('art_id' => $options['art_id'])),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * Displays a form to create a new Art entity.
     *
     */
    public function newCommentAction() {
        $entity = new Comment();
        $form = $this->createCreateForm($entity);
        return $this->render('CustomAzureusBundle:Comment:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }
}
