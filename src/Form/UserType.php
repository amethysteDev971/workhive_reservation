<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use App\Enum\UserRole;
use App\Enum\Status;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // // $form = $this->createFormBuilder($room)
        // ->add('first_name', TextType::class)
        // ->add('last_name', TextType::class)
        // ->add('photo', FileType::class)
        // ->add('user_role', ChoiceType::class)
        // ->add('phone', TextType::class)
        // ->add('email', TextType::class)
        // ->add('password', PasswordType::class)
        // ->add('status', ChoiceType::class)
        // ->add('created_at', DateTimeType::class)
        // ->add('updated_at', DateTimeType::class)

        // // ->add('save', SubmitType::class, ['label' => 'Créer une salle'])
        // // ->getForm();

        // ->add('photo', NumberType::class)
        $builder
            ->add("first_name", TextType::class)
            ->add("last_name", TextType::class)
            ->add('user_role', ChoiceType::class,[
                'label'     =>  'Status',
                'choices'   =>  array_combine(
                    array_map(fn($case) => $case->name, UserRole::cases()), // Labels
                    UserRole::cases() // Enum cases as values
                ),
                'choice_value'  =>  fn(?UserRole $userRole) =>$userRole?->value, // Maps enum to value
                'choice_label'  =>  fn(?UserRole $userRole) =>$userRole?->name,  //Maps enum to label
                'placeholder'   =>  'Choose a user',
            ])
            ->add('phone', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('status', ChoiceType::class,[
                'label'        => 'Status',
                    'choices'      => array_combine(
                        array_map(fn($case) => $case->name, Status::cases()), // Labels
                        Status::cases() // Enum cases as values
                    ),
                    'choice_value' => fn(?Status $status) => $status?->value, // Maps enum to value
                    'choice_label' => fn(?Status $status) => $status->name, // Maps enum to label
                    'placeholder'  => 'Choose a status',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'=> User::class,
        ]);
    }
}