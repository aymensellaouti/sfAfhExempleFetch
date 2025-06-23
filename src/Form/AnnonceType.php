<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\City;
use App\Entity\Gouvernorat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            ->add('gouvernorat', EntityType::class, [
                'class' => Gouvernorat::class,
                'choice_label' => 'name',
                'placeholder' => 'Ville (Choisir un gouvernorat)',
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'placeholder' => 'Département (Choisir une région)',
            ]);

        $formModifier = function (FormInterface $form, Gouvernorat $gouvernorat = null) {
            $cities = (null === $gouvernorat) ? [] : $gouvernorat->getCities();
            $form->add('city', EntityType::class, [
                'class' => City::class,
                'choices' => $cities,
                'required' => false,
                'choice_label' => 'name',
                'placeholder' => 'Ville (Choisir une ville)',
                'attr' => ['class' => 'custom-select'],
                'label' => 'Ville'
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier): void {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getGouvernorat());
            }
        );

        $builder->get('gouvernorat')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $region = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $region);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
