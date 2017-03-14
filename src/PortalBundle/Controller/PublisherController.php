<?php

namespace PortalBundle\Controller;

use PortalBundle\Entity\Publisher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Publisher controller.
 *
 * @Route("publishers")
 */
class PublisherController extends Controller
{
    /**
     * Lists all publisher entities.
     *
     * @Route("/", name="publisher_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publishers = $em->getRepository('PortalBundle:Publisher')->findAll();

        return $this->render('publisher/index.html.twig', array(
            'publishers' => $publishers,
        ));
    }

    /**
     * @Route("/search", name="publisher_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $source = array();
        $term = trim(strip_tags($request->get('term')));

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('PortalBundle:Publisher')->createQueryBuilder('p')
            ->where('p.name LIKE :name')
            ->setParameter('name', '%'.$term.'%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        foreach ($entities as $entity)
        {
            $source[] = $entity->getName();
        }

        $response = new JsonResponse();
        $response->setData($source);

        return $response;
    }

    /**
     * Creates a new publisher entity.
     *
     * @Route("/new", name="publisher_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $publisher = new Publisher();
        $form = $this->createForm('PortalBundle\Form\PublisherType', $publisher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publisher);
            $em->flush($publisher);

            return $this->redirectToRoute('publisher_show', array('id' => $publisher->getId()));
        }

        return $this->render('publisher/new.html.twig', array(
            'publisher' => $publisher,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publisher entity.
     *
     * @Route("/{id}", name="publisher_show")
     * @Method("GET")
     */
    public function showAction(Publisher $publisher)
    {
        $deleteForm = $this->createDeleteForm($publisher);

        return $this->render('publisher/show.html.twig', array(
            'publisher' => $publisher,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publisher entity.
     *
     * @Route("/{id}/edit", name="publisher_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Publisher $publisher)
    {
        $deleteForm = $this->createDeleteForm($publisher);
        $editForm = $this->createForm('PortalBundle\Form\PublisherType', $publisher);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publisher_edit', array('id' => $publisher->getId()));
        }

        return $this->render('publisher/edit.html.twig', array(
            'publisher' => $publisher,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a publisher entity.
     *
     * @Route("/{id}", name="publisher_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Publisher $publisher)
    {
        $form = $this->createDeleteForm($publisher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publisher);
            $em->flush($publisher);
        }

        return $this->redirectToRoute('publisher_index');
    }

    /**
     * Creates a form to delete a publisher entity.
     *
     * @param Publisher $publisher The publisher entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publisher $publisher)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publisher_delete', array('id' => $publisher->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
