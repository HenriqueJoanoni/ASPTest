<?php
namespace ASPHelper;

class CliPrinter
{
    /**
     * @param $message
     * @return void
     */
    public function out($message)
    {
        echo $message;
    }

    /**
     * @return void
     */
    public function newLine()
    {
        $this->out("\r\n");
    }

    /**
     * @param $message
     * @return void
     */
    public function display($message)
    {
        $this->newLine();
        $this->out($message);
        $this->newLine();
        $this->newLine();
    }

    /**
     * @param $message
     * @return void
     */
    public function displayJSON($message)
    {
        $this->newLine();
        $this->out(json_encode($message));
        $this->newLine();
        $this->newLine();
    }
}