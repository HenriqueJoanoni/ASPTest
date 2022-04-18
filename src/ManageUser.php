<?php

namespace ASPTest;

use ASPHelper\CliPrinter;
use ASPHelper\Database;
use ASPHelper\Handler;

class ManageUser
{
    /** @var CliPrinter */
    protected $printer;

    /** @var Handler */
    protected $handler;

    /** @var Database */
    protected $db;

    const DEFAULT_PASSWORD = '1234';

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->printer = new CliPrinter();
        $this->handler = new Handler();
        $this->db = new Database();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function createUser()
    {
        $stdin = fopen('php://stdin', 'r');
        $this->printer->display('Insert the first name: ');
        $firstName = $this->handler->checkSizeOfString(fgets($stdin), 'First Name');

        $this->printer->display('Insert the last name: ');
        $lastName = $this->handler->checkSizeOfString(fgets($stdin), 'Last Name');

        $this->printer->display('Insert email: ');
        $email = $this->handler->validateEmail(fgets($stdin), 'Email');

        $this->printer->display('Insert your age: ');
        $age = $this->handler->checkAge(fgets($stdin), "Age");

        $password = $this->handler->encriptPassword(self::DEFAULT_PASSWORD);
        fclose($stdin);

        $lastId = $this->db->addNewUser($firstName, $lastName, $email, $age, $password);

        if (!$lastId) {
            throw new \Exception("ERROR: could not enter this person.");
        }

        $info = [
            'ID' => $lastId,
            'First Name' => $firstName,
            'Last Name' => $lastName,
            'Email' => $email,
            'Age' => $age,
            'Password' => $password
        ];

        $this->printer->displayJSON($info);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function updatePassword()
    {
        $stdin = fopen('php://stdin', 'r');
        $this->printer->display('Insert the user ID: ');
        $userId = $this->handler->onlyNumbers(fgets($stdin));

        $this->printer->display('Insert the new Password: ');
        $newPassword = $this->handler->checkNewPassword(fgets($stdin));
        fclose($stdin);

        $userId = $this->db->checkIfUserExists($userId);

        if (!$userId) {
            throw new \Exception("ERROR: The user doest not exists.");
        }

        $newEncriptedPassword = $this->handler->encriptPassword($newPassword);

        $this->db->updatePassword($newEncriptedPassword, $userId);

        $this->printer->display("The password has been updated!");
    }
}