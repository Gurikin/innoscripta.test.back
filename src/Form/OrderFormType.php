<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('address', TextType::class)
            ->add('phone', TelType::class)
            ->add('submit', SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-dark ml-auto mr-auto text-capitalize'
                    ],
                    'label' => 'Order'
                ]
            );
    }
}