<?php

namespace PortalBundle\Controller;

use PortalBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Rating controller.
 *
 * @Route("ratings")
 */
class RatingController extends BaseController
{
    /**
     * Lists all rating entities.
     *
     * @Route("/", name="rating_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $ratings = $this->getRepo('PortalBundle:Rating')->findAll();

        return $this->render('rating/index.html.twig', array(
            'ratings' => $ratings,
        ));
    }

    /**
     * Creates a new rating entity.
     *
     * @Route("/new", name="rating_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rating = new Rating();
        $form = $this->createForm('PortalBundle\Form\RatingType', $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush($rating);

            return $this->redirectToRoute('rating_show', array('id' => $rating->getId()));
        }

        return $this->render('rating/new.html.twig', array(
            'rating' => $rating,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rating entity.
     *
     * @Route("/{id}", name="rating_show")
     * @Method("GET")
     */
    public function showAction(Rating $rating)
    {
        $deleteForm = $this->createDeleteForm($rating);

        return $this->render('rating/show.html.twig', array(
            'rating' => $rating,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rating entity.
     *
     * @Route("/{id}/edit", name="rating_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rating $rating)
    {
        $deleteForm = $this->createDeleteForm($rating);
        $editForm = $this->createForm('PortalBundle\Form\RatingType', $rating);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rating_edit', array('id' => $rating->getId()));
        }

        return $this->render('rating/edit.html.twig', array(
            'rating' => $rating,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rating entity.
     *
     * @Route("/{id}", name="rating_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rating $rating)
    {
        $form = $this->createDeleteForm($rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rating);
            $em->flush($rating);
        }

        return $this->redirectToRoute('rating_index');
    }

    /**
     * Creates a form to delete a rating entity.
     *
     * @param Rating $rating The rating entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rating $rating)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rating_delete', array('id' => $rating->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
