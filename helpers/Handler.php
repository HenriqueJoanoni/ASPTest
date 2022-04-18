<?php

namespace ASPHelper;

class Handler
{
    /** @var CliPrinter */
    private $printer;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->printer = new CliPrinter();
    }

    /**
     * @param string $string
     * @param string $stringName
     * @return string
     * @throws \Exception
     */
    public function checkSizeOfString(string $string, string $stringName)
    {
        if (!isset($string)) {
            throw new \Exception("ERROR: Parameter {$stringName} is mandatory.");
        }

        $string = trim(filter_var($string, FILTER_SANITIZE_STRING));
        $sizeOf = mb_strlen($string);

        if ($sizeOf < 2 || $sizeOf > 35) {
            throw new \Exception("ERROR: {$stringName} string must contain min 2 and max 35 characters.");
        }

        return $string;
    }

    /**
     * @param string $string
     * @param string $stringName
     * @return mixed
     * @throws \Exception
     */
    public function validateEmail(string $string, string $stringName)
    {
        if (!isset($string)) {
            throw new \Exception("ERROR: Parameter {$stringName} is mandatory.");
        }

        $string = filter_var(trim($string), FILTER_VALIDATE_EMAIL);

        if ($string == false) {
            throw new \Exception("ERROR: Parameter {$stringName} is considered invalid.");
        }

        return $string;
    }

    /**
     * @param string $string
     * @param string $stringName
     * @return string|null
     * @throws \Exception
     */
    public function checkAge(string $string, string $stringName = '')
    {
        if (!isset($string)) {
            return null;
        }

        $string = trim(filter_var($string, FILTER_SANITIZE_STRING));
        $sizeOf = mb_strlen($string);

        if ($sizeOf > 4) {
            throw new \Exception("ERROR: {$stringName} must contain max 4 characters.");
        }

        if ((int)$string < 0) {
            throw new \Exception("ERROR: {$stringName} cannot be negative.");
        }

        if ((int)$string > 150) {
            throw new \Exception("ERROR: {$stringName} cannot be higher than 150 years");
        }

        return $string;
    }

    /**
     * @param string $string
     * @return mixed|void
     * @throws \Exception
     */
    public function checkNewPassword(string $string)
    {
        if (!isset($string)) {
            $this->printer->display('No new Password Set. Exiting...');
            exit;
        }

        $string = filter_var(trim($string, FILTER_SANITIZE_STRING));
        $sizeOf = mb_strlen($string);

        if ($sizeOf < 6) {
            throw new \Exception("ERROR: The new password must contain min 6 characters.");
        }

        if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string)) {
            throw new \Exception("ERROR: The new password must contain at least 1 special character");
        }

        if (!preg_match('/[A-Z]/', $string)) {
            throw new \Exception("ERROR: The new password must contain at least 1 capital letter.");
        }

        if (!preg_match('/[0-9]/',$string)) {
            throw new \Exception("ERROR: The new password must contain at least 1 number.");
        }

        return $string;
    }

    /**
     * @param string $string
     * @return array|string|string[]|null
     * @throws \Exception
     */
    public function onlyNumbers(string $string)
    {
        if (!isset($string)) {
            throw new \Exception("ERROR: The user must be declared.");
        }

        return preg_replace('/\D/', '', trim($string));
    }

    /**
     * @param string $string
     * @return false|string|null
     * @throws \Exception
     */
    public function encriptPassword(string $string)
    {
        if (!$string) {
            throw new \Exception("ERROR: No password defined");
        }

        return password_hash($string, PASSWORD_BCRYPT);
    }
}