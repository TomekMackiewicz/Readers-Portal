<?php

namespace PortalBundle\Controller;

use PortalBundle\Entity\Translator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Translator controller.
 *
 * @Route("translator")
 */
class TranslatorController extends Controller
{
    /**
     * Lists all translator entities.
     *
     * @Route("/", name="translator_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $translators = $em->getRepository('PortalBundle:Translator')->findAll();

        return $this->render('translator/index.html.twig', array(
            'translators' => $translators,
        ));
    }

    /**
     * Creates a new translator entity.
     *
     * @Route("/new", name="translator_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $translator = new Translator();
        $form = $this->createForm('PortalBundle\Form\TranslatorType', $translator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($translator);
            $em->flush($translator);

            return $this->redirectToRoute('translator_show', array('id' => $translator->getId()));
        }

        return $this->render('translator/new.html.twig', array(
            'translator' => $translator,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a translator entity.
     *
     * @Route("/{id}", name="translator_show")
     * @Method("GET")
     */
    public function showAction(Translator $translator)
    {
        $deleteForm = $this->createDeleteForm($translator);

        return $this->render('translator/show.html.twig', array(
            'translator' => $translator,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing translator entity.
     *
     * @Route("/{id}/edit", name="translator_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Translator $translator)
    {
        $deleteForm = $this->createDeleteForm($translator);
        $editForm = $this->createForm('PortalBundle\Form\TranslatorType', $translator);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('translator_edit', array('id' => $translator->getId()));
        }

        return $this->render('translator/edit.html.twig', array(
            'translator' => $translator,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a translator entity.
     *
     * @Route("/{id}", name="translator_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Translator $translator)
    {
        $form = $this->createDeleteForm($translator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($translator);
            $em->flush($translator);
        }

        return $this->redirectToRoute('translator_index');
    }

    /**
     * Creates a form to delete a translator entity.
     *
     * @param Translator $translator The translator entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Translator $translator)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('translator_delete', array('id' => $translator->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
