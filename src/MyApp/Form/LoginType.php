<?php

namespace MyApp\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class LoginType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('email', 'email', array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Email()
                )
            ))
            ->add('password', 'password', array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array('min' => 8, 'max' => 20))
                )
            ))
            ->add('submit', 'submit', array('label' => 'Login'))
        ;
    }

    public function getName() {
        return 'blog_login';
    }
}
