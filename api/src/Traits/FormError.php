<?php

namespace App\Traits;

use Symfony\Component\Form\FormInterface;

trait FormError
{
    protected function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $errors[$error->getOrigin()?->createView()->vars['full_name'] ?? 'root'][] = $error->getMessage();
        }

        return $errors;
    }
}