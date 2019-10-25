<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\Type\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    /**
     * @Route("/person", name="person")
     */
    public function index()
    {
        $people = $this->getDoctrine()->getRepository('App:Person')->findAll();

        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController', 'people' => $people
        ]);
    }

    /**
     * @Route("/person/create", name="create-person")
     *
     */
    public function create(Request $request)
    {
        $person = new Person();

        $form = $this->createFormBuilder($person)
            ->add('typeperson',PersonType::class)
            ->add('identifier', NumberType::class)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class, ['label'=>'Create person'])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $person = $form->getData();

            $id = $person->getIdentifier();
            if(strlen($id) < 11 || strlen($id) > 15) {
                $this->addFlash('warning', 'Ops, we got an error!');
                return $this->redirect('/person/create');
            }

            $p = $this->getDoctrine()->getManager();
            $p->persist($person);
            $p->flush();

            $this->addFlash('success', 'Person created!');
            return $this->redirect('/person');
        }

        return $this->render('person/create.html.twig', [
            'controller_name' => 'PersonController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/person/update/{id}", name="edit-person")
     */
    public function update(Request $request ,$id)
    {
        $p = $this->getDoctrine()->getManager();
        $person = $p->getRepository('App:Person')->find($id);

        if (!$person) {
            throw $this->createNotFoundException(
                'There are no person with the following id: ' . $id
            );
        }

        $form = $this->createFormBuilder($person)
            ->add('typeperson',PersonType::class)
            ->add('identifier', NumberType::class)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class, ['label'=>'Update person'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $person = $form->getData();
            $p->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            return $this->redirect('/person');
        }

        return $this->render('/person/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/person/delete/{id}", name="delete-person")
     */
    public function delete($id)
    {
    $p = $this->getDoctrine()->getManager();
        $person = $p->getRepository('App:Person')->find($id);

        if (!$person) {
            throw $this->createNotFoundException(
                'There are no person with the following id: ' . $id
            );
        }

        $p->remove($person);
        $p->flush();

        return $this->redirect('/person');
    }
}
