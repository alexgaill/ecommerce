<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = new User();
        $user->setCreatedAt(new \Datetime())
            ->setCodeValidation('creer code et balancer ici');

        $builder
            ->add('nom', null, ['label' => false])
            ->add('prenom', null, ['label' => false])
            ->add('adresse', null, ['label' => false])
            ->add('code_postal', null, ['label' => false])
            ->add('ville', null, ['label' => false])
            ->add('email', EmailType::Class, ['label' => false])
            ->add('telephone', null, ['label' => false])
            ->add('password', PasswordType::Class, ['label' => false])
            ->add('password_verify', PasswordType::Class, ['label' => false])
            // ->add('code_validation')
            // ->add('valide')
            // ->add('created_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
