<?php

namespace Etmp\Help;

use Etmp\Foundation\Controller;
use Etmp\Render\Message;

class HelpController implements Controller {
    /**
     * Add the header sections
     *
     * @param  Etmp\Render\Message $message
     * @return void
     */
    private function addHeader(Message $message)
    {
        $message
            ->section('Welcome to ETMP Cli')
            ->section('Usage: php index.php [action] [options]');
    }
    
    /**
     * Add the action part of the message
     *
     * @param  Etmp\Render\Message $message
     * @return void
     */
    private function addActions(Message $message)
    {
        $message
            ->section('Actions')
            ->description([
                ['help', 'Displays the help section with all available actions and options'],
                ['job', 'Runs the job, handling the adress replacement and the storage'],
                ['verify', 'Lets you verify configuration and test storage'],
            ]);
    }

    /**
     * Add the header sections
     *
     * @param  Etmp\Render\Message $message
     * @return void
     */
    private function addOptions(Message $message)
    {
        $message
            ->section('Options')
            ->description([
                ['-s', 'Only fetches the adress through the job command, avoids saving it.'] 
            ]);
    }
    
    public function dispatch(): Message
    {
        $message = new Message();
        $this->addHeader($message);
        $this->addActions($message);
        $this->addOptions($message);
        
        return $message;
    }
}