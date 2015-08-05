<?php

namespace MyApp\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('comment', 'textarea', array(
                'constraints' => array(
                    new Assert\Length(array('min' => 20, 'max' => 140))
                )
            ))
        ;
    }

    public function getName() {
        return 'blog_comment';
    }
}
