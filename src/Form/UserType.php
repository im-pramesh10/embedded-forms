<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();

        $this->countries = $this->em->getRepository(Country::class)->findAll();
        $this->countryChoice = array();

        foreach ($this->countries as $country) {
            $this->countryChoice[$country->getCountry()] = $country;
        }
        //dump($this->countryChoice);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        /* $em = $this->doctrine->getManager();
        $countries = new Country();
        $countries = $em->getRepository(Country::class)->findAll();*/
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('country', ChoiceType::class, [
                'choices' => $this->countryChoice,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]) //make dropdown of this field later and populate with database value
            ->add('info', CollectionType::class, [
                'entry_type' => InfoType::class,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,

                'allow_add' => true,

                'allow_delete' => true
            ])

            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
