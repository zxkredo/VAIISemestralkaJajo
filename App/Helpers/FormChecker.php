<?php

namespace App\Helpers;

use DateTime;

class FormChecker
{
    public static function checkUpdatePersonalDetailForm($formData): bool
    {
        if (!isset($formData['submit'])
            || !isset($formData['name'])
            || !isset($formData['surname'])
            || !isset($formData['birthDate'])
            || !isset($formData['street'])
            || !isset($formData['city'])
            || !isset($formData['postalCode'])
        ) {
            return false;
        }

        if (empty($formData['name'])
            || empty($formData['surname'])
            || empty($formData['birthDate'])
            || empty($formData['street'])
            || empty($formData['city'])
            || empty($formData['postalCode']
            )
        ) {
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

        return true;
    }
    public static function checkAllPersonalDetailForm($formData): bool
    {

        if (!isset($formData['password'])
            || !isset($formData['email'])
            || !isset($formData['gender'])
        ) {
            return false;
        }

        if (empty($formData['email'])
            || empty($formData['password'])
            || empty($formData['gender'])
        ) {
            return false;
        }

        $gender = $formData['gender'];
        if ($gender !== "female" && $gender !== "male" && $gender !== "other") {
            return false;
        }

        $email = $formData['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return self::checkUpdatePersonalDetailForm($formData);
    }
    public static function sanitizeUpdatePersonalDetail($formData, &$name, &$surname, &$birthDate, &$street, &$city, &$postalCode) : void
    {
        if (!is_null($formData['surname']))
        {
            $name = trim(strip_tags($formData['name']));
        }
        if (!is_null($formData['surname'])) {
            $surname = trim(strip_tags($formData['surname']));
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
    }

    public static function sanitizeAll($formData, &$name, &$surname, &$gender, &$birthDate, &$street, &$city, &$postalCode, &$email, &$password) : void
    {
        self::sanitizeUpdatePersonalDetail($formData, $name, $surname, $birthDate, $street, $city, $postalCode);

        if (!is_null($formData['gender'])) {
            $gender = trim(strip_tags($formData['gender']));
        }

        if (!is_null($formData['password'])) {
            $password = htmlspecialchars($formData['password']);
        }

        if (!is_null($formData['email'])) {
            $email = trim(strip_tags($formData['email']));
        }
    }
}