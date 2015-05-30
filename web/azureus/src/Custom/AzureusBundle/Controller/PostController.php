<?php

namespace Custom\AzureusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Custom\AzureusBundle\Entity\Post;
use Custom\AzureusBundle\Form\PostType;

use Custom\AzureusBundle\Entity\PostComment;
use Custom\AzureusBundle\Entity\Comment;
use Custom\AzureusBundle\Form\CommentType;
/**
 * Post controller.
 *
 */
class PostController extends Controller {

    /**
     * Lists all Post entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();


        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $criteria = array('owner' => $this->getUser()->getId());
            $entities = $em->getRepository('CustomAzureusBundle:Post')->findBy($criteria);
        } else {
            $entities = $em->getRepository('CustomAzureusBundle:Post')->findAll();
        }

        return $this->render('CustomAzureusBundle:Post:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Post entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Post();
        $form = $this->createCreateForm($entity, array('is_admin' => $this->get('security.context')->isGranted('ROLE_ADMIN')));
        $form->handleRequest($request);
        if ($form->isValid()) {
            if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $entity->setOwner($this->get('security.context')->getToken()->getUser());
            }

            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('post_show', array('id' => $entity->getId())));
        }
        return $this->render('CustomAzureusBundle:Post:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Post entity.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Post $entity) {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('post_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * Displays a form to create a new Post entity.
     *
     */
    public function newAction() {
        $entity = new Post();
        $form = $this->createCreateForm($entity);
        return $this->render('CustomAzureusBundle:Post:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CustomAzureusBundle:Post')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }
        
        $comments_criteria = array('parent' => $entity->getId());
        $comments = $em->getRepository('CustomAzureusBundle:PostComment')->findBy($comments_criteria, ['date' => 'DESC'], 5);
        
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('CustomAzureusBundle:Post:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                    'comments' => $comments,
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CustomAzureusBundle:Post')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
            return $this->render('CustomAzureusBundle:Fun:ydtmw.html.twig');
        }

        //TODO O KURCZE MUSZE TO ZMIENIC
        if ($entity->getOwner()) {
            if ($this->getUser()->getId() === $entity->getOwner()->getId() OR $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $editForm = $this->createEditForm($entity);
                $deleteForm = $this->createDeleteForm($id);
                return $this->render('CustomAzureusBundle:Post:edit.html.twig', array(
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
     * Creates a form to edit a Post entity.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Post $entity) {
        if ($entity->getOwner()) {
            if ($this->getUser()->getId() === $entity->getOwner()->getId() OR $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(new PostType(), $entity, array(
                    'action' => $this->generateUrl('post_update', array('id' => $entity->getId())),
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
     * Edits an existing Post entity.
     *
     */
    public function updateAction(Request $request, $id) {
        if ($entity->getOwner()) {
            if ($this->getUser()->getId() === $entity->getOwner()->getId() OR $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('CustomAzureusBundle:Post')->find($id);
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Post entity.');
                }
                $deleteForm = $this->createDeleteForm($id);
                $editForm = $this->createEditForm($entity);
                $editForm->handleRequest($request);
                if ($editForm->isValid()) {
                    $em->flush();
                    return $this->redirect($this->generateUrl('post_edit', array('id' => $id)));
                }
                return $this->render('CustomAzureusBundle:Post:edit.html.twig', array(
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
     * Deletes a Post entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CustomAzureusBundle:Post')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('post'));
    }

    /**
     * Creates a form to delete a Post entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('post_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * Creates a new Post entity.
     *
     */
    public function createCommentAction(Request $request, $post_id) {
        $entity = new PostComment();
        $form = $this->createCommentCreateForm($entity, array('post_id' => $post_id, 'is_admin' => $this->get('security.context')->isGranted('ROLE_ADMIN')));
        $form->handleRequest($request);
        if ($form->isValid()) {
            // If we aren't admin then set us as an owner
            if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
                $entity->setOwner($this->get('security.context')->getToken()->getUser());
            }
            
            $em = $this->getDoctrine()->getManager();

            $parent = $em->getRepository('CustomAzureusBundle:Post')->find($post_id);
            $entity->setParent($parent);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('post_show', array('id' => $post_id)));
        }
        
        // To zmienic
        return $this->render('CustomAzureusBundle:Comment:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Post entity.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCommentCreateForm(PostComment $entity, $options) {
        $form = $this->createForm(new CommentType(), $entity, array(
            'action' => $this->generateUrl('post_comment_create', array('post_id' => $options['post_id'])),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * Displays a form to create a new Post entity.
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
