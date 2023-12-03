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

    public static function sanitize($formData, &$name, &$surname, &$gender, &$birthDate, &$street, &$city, &$postalCode, &$email, &$password) : void
    {
        if (!is_null($formData['surname']))
        {
            $name = trim(strip_tags($formData['name']));
        }
        if (!is_null($formData['surname'])) {
            $surname = trim(strip_tags($formData['surname']));
        }

        if (!is_null($formData['gender'])) {
            $gender = trim(strip_tags($formData['gender']));
        }

        if (!is_null($formData['birthDate'])) {
            $birthDate = DateTime::createFromFormat('Y-m-d', $formData['birthDate']);
        }

        if (!is_null($formData['street'])) {
            $street = trim(strip_tags($formData['street']));
        }

        if (!is_null($formData['city'])) {
            $city = trim(strip_tags($formData['city']));
        }

        if (!is_null($formData['postalCode'])) {
            $postalCode = str_replace(" ", "", $formData['postalCode']);
        }

        if (!is_null($formData['email'])) {
            $email = trim(strip_tags($formData['email']));
        }

        if (!is_null($formData['password'])) {
            $password = htmlspecialchars($formData['password']);
        }
    }
}