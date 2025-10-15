<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
                'attr' => ['placeholder' => 'Ex: 9781234567890'],
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre du livre',
                'attr' => ['placeholder' => 'Ex: Le Petit Prince'],
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Résumé',
                'attr' => ['rows' => 4],
            ])
            ->add('publicationYear', IntegerType::class, [
                'label' => 'Année de publication',
            ])
            ->add('issueDate', DateType::class, [
                'label' => 'Date d\'emprunt (facultative)',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('Save', SubmitType::class, [
                'label' => 'Enregistrer le livre',
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'book_item',
        ]);
    }
}
