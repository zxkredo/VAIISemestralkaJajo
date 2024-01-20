<?php

namespace App\Helpers;

use DateTime;

class FormChecker
{
    /**
     * Returns true if submit is in form.
     * @param $formData
     * @return bool True if submit is present
     */
    public static function checkSubmit($formData) : bool
    {
        return isset($formData['submit']);
    }
    public static function checkUpdatePersonalDetailForm($formData): bool
    {
        if (!self::checkSubmit($formData)
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
    public static function checkUpdateLoginForm($formData): bool
    {
        if (!self::checkSubmit($formData)
            ||!isset($formData['password'])
            || !isset($formData['email'])
        ) {
            return false;
        }

        if (empty($formData['email'])
            || empty($formData['password'])
        ) {
            return false;
        }

        $email = $formData['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    public static function checkAllPersonalDetailForm($formData): bool
    {
        if (!isset($formData['gender'])
        ) {
            return false;
        }

        if (empty($formData['gender'])
        ) {
            return false;
        }

        $gender = $formData['gender'];
        if ($gender !== "female" && $gender !== "male" && $gender !== "other") {
            return false;
        }

        return self::checkUpdateLoginForm($formData) && self::checkUpdatePersonalDetailForm($formData);
    }
    public static function sanitizeUpdateLogin($formData, &$email, &$password) : void
    {
        if (!is_null($formData['password'])) {
            $password = htmlspecialchars($formData['password']);
        }

        if (!is_null($formData['email'])) {
            $email = trim(strip_tags($formData['email']));
        }
    }
    public static function sanitizeUpdatePersonalDetail($formData, &$name, &$surname, &$birthDate, &$street, &$city, &$postalCode) : void
    {
        if (!is_null($formData['name']))
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

    public static function sanitizeAllNastaveniaForm($formData, &$name, &$surname, &$gender, &$birthDate, &$street, &$city, &$postalCode, &$email, &$password) : void
    {
        self::sanitizeUpdatePersonalDetail($formData, $name, $surname, $birthDate, $street, $city, $postalCode);
        self::sanitizeUpdateLogin($formData, $email, $password);

        if (!is_null($formData['gender'])) {
            $gender = trim(strip_tags($formData['gender']));
        }
    }

    public static function checkAllRunUpdateForm(array $formData) : bool
    {
        if (!self::checkSubmit($formData)
            || !isset($formData['name'])
            || !isset($formData['location'])
            || !isset($formData['description'])
            || !isset($formData['capacity'])
            || !isset($formData['price_in_cents'])
        ) {
            return false;
        }

        if (empty($formData['name'])
            || empty($formData['location'])
            || empty($formData['description'])
            || empty($formData['capacity'])
            || empty($formData['price_in_cents'])
        ) {
            return false;
        }

        return true;
    }

    public static function sanitizeAllRunUpdateForm(array $formData, array $files, &$name, &$location, &$description, &$capacity, &$price_in_cents, &$picture_name): void
    {
        if (!is_null($formData['name']))
        {
            $name = trim(strip_tags($formData['name']));
        }
        if (!is_null($formData['location']))
        {
            $location = trim(strip_tags($formData['location']));
        }
        if (!is_null($formData['description']))
        {
            $description = trim(strip_tags($formData['description']));
        }
        if (!is_null($formData['capacity']))
        {
            $capacity = (int)trim(strip_tags($formData['capacity']));
        }
        if (!is_null($formData['price_in_cents']))
        {
            $price_in_cents = (int)trim(strip_tags($formData['price_in_cents']));
        }
        if (!empty($files['picture']['name']))
        {
            $picture_name = trim(htmlspecialchars($files['picture']['name']));
        }
        else
        {
            $picture_name = "";
        }
    }


    public static function checkAllRunForm(array $formData, array $files) : bool
    {
        if (!self::checkAllRunUpdateForm($formData)
        ) {
            return false;
        }
        if (!isset($files['picture']['name'])
        ) {
            return false;
        }

        if (empty($files['picture']['name'])
        ) {
            return false;
        }

        return true;
    }

    public static function sanitizeAllRunForm(array $formData, array $files, &$name, &$location, &$description, &$capacity, &$price_in_cents, &$picture_name) : void
    {
        self::sanitizeAllRunUpdateForm($formData, $files, $name, $location, $description, $capacity, $price_in_cents, $picture_name);
    }

    public static function checkRunId(array $formData) : bool
    {
        return isset($formData['id']);
    }

    public static function sanitizeEmail(string &$email): void
    {
        $email = trim(strip_tags($email));
    }
}