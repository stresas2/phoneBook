<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Entity\ContactReq;
use App\Entity\User;
use App\Form\ContactTypes;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ContactController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/list", name="list")
     * @Method({"GET"})
     */
    public function contactlist()
    {
        $userId = $this->getUser()->getId();

        $phoneBookList = $this->getDoctrine()->getRepository(Contacts::class)->findBy(['fk_user' => $userId]);

        $UserList = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('contacts/index.html.twig', array('list' => $phoneBookList, 'userList' => $UserList));
    }

    /**
     * @Route("/send/{id}", name="send")
     * @Method({"GET"})
     */
    public function send($id)
    {
        $contact = $this->getDoctrine()->getRepository(Contacts::class)->findBy(['id' => $id]);

        if(empty($contact)){
            return $this->redirect('/list');
        }

        $creator = $contact[0]->getFkUser();
        if($this->getUser() !== $creator){
            return $this->redirect('/list');
        }

        $Users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $data = array();

        $sendContact = $this->getDoctrine()->getRepository(Contacts::class)->find($id);

        foreach ($Users as $user) {
            if ($user !== $this->getUser()) {
                $search = $this->getDoctrine()->getRepository(ContactReq::class)->findBy(['fk_receiving_user' => $user, 'name' => $sendContact->getName(), 'number' => $sendContact->getNumber()]);
                if (!$search) {
                    array_push($data, $user);
                }
            }
        }

        if (empty($data)) {
            return $this->render('contacts/send.html.twig', array('message' => 'Sorry, there is no user available to send!'));
        }

        return $this->render('contacts/send.html.twig', array('data' => $contact, 'users' => $data, 'message' => ''));
    }

    /**
     * @Route("/contact/new", name="newcontact")
     * @Method({"GET", "POST"})
     */
    public function newcontact(Request $request)
    {
        $user = $this->getUser();

        $phoneContact = new Contacts();
        $form = $this->createForm(ContactTypes::class, $phoneContact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $phone = $form->getData();
            $phone->setFkUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($phone);
            $entityManager->flush();
            return $this->redirectToRoute('list');
        }
        return $this->render('contacts/new.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route ("/contact/delete/{id}", name="delete")
     * @Method ({"DELETE"})
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $this->getDoctrine()->getRepository(Contacts::class)->find($id);

        if(empty($contact)){
            return $this->redirect('/list');
        }

        $creator = $contact->getFkUser();
        if($this->getUser() !== $creator){
            return $this->redirect('/list');
        }

        if (!$contact) {
            throw $this->createNotFoundException(
                'There are no contacts with the following id: ' . $id
            );
        }

        $em->remove($contact);
        $em->flush();

        return $this->redirect('/list');
    }

    /**
     * @Route("/contact/edit/{id}", name="edit")
     * @Method({"GET", "POST"})
     */
    public function editcontact(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $this->getDoctrine()->getRepository(Contacts::class)->find($id);

        if(empty($contact)){
            return $this->redirect('/list');
        }

        $creator = $contact->getFkUser();
        if($this->getUser() !== $creator){
            return $this->redirect('/list');
        }

        $form = $this->createForm(ContactTypes::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $contact = $form->getData();
            $em->flush();
            return $this->redirect('/list');
        }

        return $this->render(
            'contacts/edit.html.twig',
            array('form' => $form->createView())
        );
    }
}
