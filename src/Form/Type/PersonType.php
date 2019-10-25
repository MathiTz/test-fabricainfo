<?php
// src/Form/Type/PersonType.php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
            'Física' => 'Física',
            'Jurídica' => 'Jurídica'
        ],
        ]);

    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}