<?php

namespace App\Helpers;

use DateTime;

class FormChecker
{
    public static function checkPersonalDetailFormWithoutPassword($formData): bool
    {
        if (!isset($formData['submit'])
            || !isset($formData['name'])
            || !isset($formData['surname'])
            || !isset($formData['gender'])
            || !isset($formData['birthDate'])
            || !isset($formData['street'])
            || !isset($formData['city'])
            || !isset($formData['postalCode'])
            || !isset($formData['email'])
        ) {
            return false;
        }

        if (empty($formData['name'])
            || empty($formData['surname'])
            || empty($formData['gender'])
            || empty($formData['birthDate'])
            || empty($formData['street'])
            || empty($formData['city'])
            || empty($formData['postalCode'])
            || empty($formData['email'])
        ) {
            return false;
        }

        $gender = $formData['gender'];
        if ($gender !== "female" && $gender !== "male" && $gender !== "other") {
            return false;
        }

        $birthDate = DateTime::createFromFormat('Y-m-d', $formData['birthDate']);
        if (!$birthDate || $birthDate->format('Y-m-d') !== $formData['birthDate']) {
            return false;
        }

        $postalCode = $formData['postalCode'];
        if (!preg_match('/\d{3} ?\d{2}$/', $postalCode)) {
            return false;
        }

        $email = $formData['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
    public static function checkPersonalDetailForm($formData): bool
    {
        if ( !isset($formData['password'])
        ) {
            return false;
        }

        if ( empty($formData['email'])
            || empty($formData['password'])
        ) {
            return false;
        }

        return self::checkPersonalDetailFormWithoutPassword($formData);
    }
}