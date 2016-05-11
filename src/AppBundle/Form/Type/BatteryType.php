<?php
/**
 * Created by PhpStorm.
 * User: v.bunchuk
 * Date: 11/05/2016
 * Time: 16:06
 */

// src/AppBundle/Form/Type/BatteryType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class BatteryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(array('max' => 10))
                    ],
                ]
            )
            ->add('count', IntegerType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(array('max' => 10)),
                    ],
                ]
            )
            ->add('name', TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(array('max' => 20))
                    ],
                ]
            )
            ->add('save', SubmitType::class, ['label' => 'Drop the batteries']);
    }
}