<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Room;
use App\Enum\Status;

class RoomType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $form = $this->createFormBuilder($room)
        // ->add('name', TextType::class)
        // ->add('capacity', IntegerType::class)
        // ->add('width', NumberType::class)
        // ->add('length', NumberType::class)
        // ->add('save', SubmitType::class, ['label' => 'Créer une salle'])
        // ->getForm();

        $builder
            ->add("name", TextType::class)
            ->add("capacity", IntegerType::class)
            ->add('width', NumberType::class)
            ->add('length', NumberType::class)
            ->add('status', ChoiceType::class, [
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
            'data_class'=> Room::class,
        ]);
    }
}