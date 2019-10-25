<?php

namespace App\Controller;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     */
    public function create(Request $request)
    {
        $person = new Person();
        $person->setTypePerson('Física');
        $person->setIdentifier('06601625396');
        $person->setName('Matheus Alves Peixoto dos Santos');

        $form = $this->createFormBuilder($person)
            ->add('typeperson', TextType::class)
            ->add('identifier', NumberType::class)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label'=>'Create person'])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $person = $form->getData();

            $p = $this->getDoctrine()->getManager();
            $p->persist($person);
            $p->flush();

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
            ->add('typeperson', TextType::class)
            ->add('identifier', NumberType::class)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label'=>'Update person'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $person = $form->getData();
            $p->flush();

            return $this->redirect('/person/');
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
