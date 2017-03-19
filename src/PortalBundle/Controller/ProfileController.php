<?php

namespace PortalBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller managing the reader profile.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{
    /**
     * Show reader's profile.
     */
    public function showAction()
    {
        if (!is_object($this->getUser()) || !$this->getUser() instanceof UserInterface) {
            throw new AccessDeniedException('This reader does not have access to this section.');
        }
        $books          = $this->getRepo('PortalBundle:Reader')->getReaderBooks($this->getUser()->getId());
        $ratings        = $this->getRepo('PortalBundle:Reader')->getReaderRatings($this->getUser()->getId());
        $reviews        = $this->getRepo('PortalBundle:Reader')->getReaderReviews($this->getUser()->getId());
        $favouriteBooks = $this->getRepo('PortalBundle:FavouriteBook')->showFavouriteBooks($this->getUser()->getId()); 
        $currentBooks   = $this->getRepo('PortalBundle:CurrentBook')->showCurrentBooks($this->getUser()->getId());
        $wantedBooks    = $this->getRepo('PortalBundle:WantedBook')->showWantedBooks($this->getUser()->getId());

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'reader'            => $this->getUser(),
            'books'             => $books,
            'ratings'           => $ratings,
            'reviews'           => $reviews,
            'favouriteBooks'    => $favouriteBooks,
            'currentBooks'      => $currentBooks,
            'wantedBooks'       => $wantedBooks
        ));
    }

    /**
     * Edit the reader.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $reader = $this->getUser();
        if (!is_object($reader) || !$reader instanceof UserInterface) {
            throw new AccessDeniedException('This reader does not have access to this section.');
        }

        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($reader, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($reader);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($reader);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($reader, $request, $response));

            return $response;
        }

        return $this->render('@FOSUser/Profile/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}