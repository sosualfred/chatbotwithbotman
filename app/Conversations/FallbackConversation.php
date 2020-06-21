<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class FallbackConversation extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("Invalid Response. Try the commands below")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Hear a joke')->value('joke'),
                Button::create('Give me a fancy quote')->value('quote'),
                Button::create('My commands')->value('powers')
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'joke') {
                    $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    $this->say("This is a joke for you: ".$joke->value->joke);
                }
                elseif ($answer->getValue() === 'quote') {
                    $this->say("This is an inspiring quote: ".Inspiring::quote());
                }
                else {
                    $this->say("These are my commands: <br><br> <strong>commands</strong> - List all commands <br>
                    <strong>who is your creator</strong> <br> <strong>what is your purpose</strong>");
                }
            }
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
