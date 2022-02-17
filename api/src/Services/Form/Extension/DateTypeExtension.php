<?php

namespace App\Services\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateTypeExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'date_picker' => true,
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'html5' => false,
            'model_timezone' => 'Europe/Paris',
            'view_timezone' => 'Europe/Paris',
            'today_btn' => true,
        ]);
    }

    public static function getExtendedTypes(): array
    {
        return [DateType::class];
    }
}
