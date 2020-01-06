<?php

namespace App\Controller;

use App\Entity\ContactReq;
use App\Entity\Contacts;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RequestController extends AbstractController
{

    /**
     * @Route("/upload", name="upload")
     * @Method({"GET", "POST"})
     */
    public function uploadRequest(Request $request)
    {
        $email = $request->get('email', '');
        $id = $request->get('id', '');

        $contact = $this->getDoctrine()->getRepository(Contacts::class)->find($id);

        if(empty($contact)){
            return $this->redirect('/request');
        }

        $creator = $contact->getFkUser();
        if($this->getUser() !== $creator){
            return $this->redirect('/request');
        }

        $receiverUser = $this->getDoctrine()->getRepository(User::class)->findBy(['email' => $email]);
        $senderUser = $this->getUser();

        $requestContact = new ContactReq();
        $requestContact->setName($contact->getName());
        $requestContact->setNumber($contact->getNumber());
        $requestContact->setFkReceivingUser($receiverUser[0]);
        $requestContact->setFkSendingUser($senderUser);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($requestContact);
        $entityManager->flush();

        return $this->redirectToRoute('request');
    }

    /**
     * @Route("/request", name="request")
     * @Method({"GET"})
     */
    public function request()
    {
        $User = $this->getUser();
        $sendContact = $this->getDoctrine()->getRepository(ContactReq::class)->findBy(['fk_sending_user' => $User]);

        $receiveContact = $this->getDoctrine()->getRepository(ContactReq::class)->findBy(['fk_receiving_user' => $User]);

        return $this->render('contacts/request.html.twig', array('sendData' => $sendContact, 'receiveData' => $receiveContact));
    }

    /**
     * @Route("/request/delete", name="deleterequest")
     * @Method({"POST"})
     */
    public function deleteRequest(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $contact = $this->getDoctrine()->getRepository(ContactReq::class)->find($id);

        if(empty($contact)){
            return $this->redirect('/request');
        }

        $em->remove($contact);
        $em->flush();

        return $this->redirect('/request');
    }

    /**
     * @Route("/request/save", name="saverequest")
     * @Method({"POST"})
     */
    public function saveRequest(Request $request)
    {
        $requestId = $request->get('id');

        $requestContact = $this->getDoctrine()->getRepository(ContactReq::class)->find($requestId);

        if(empty($requestContact)){
            return $this->redirect('/request');
        }

        $newContact = new Contacts();

        $user = $this->getUser();

        $newContact->setName($requestContact->getName());
        $newContact->setNumber($requestContact->getNumber());
        $newContact->setFkUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($newContact);
        $entityManager->remove($requestContact);
        $entityManager->flush();

        return $this->redirect('/request');
    }
}
