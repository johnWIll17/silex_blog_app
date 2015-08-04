<?php

namespace MyApp\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array('min' => 5))
                )
            ))
            ->add('description', 'text', array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array('max' => 140))
                )
            ));
    }

    public function getName() {
        return 'blog_article';
    }
}
