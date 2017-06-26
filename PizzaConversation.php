<?php

use BotMan\BotMan\Messages\Conversations\Conversation;
	
class PizzaConversation extends Conversation
{
	protected $size;
	protected $topping;
	protected $address;

	public function run()
	{
		$this->ask('What Pizza size do you want?', function($answer) {
			$this->size = $answer->getText();
			$this->askTopping();
		});
	}

	public function askTopping()
	{
		$this->ask('What kind of topping do you want?', function($answer) {
			$this->topping = $answer->getText();
			$this->askAddress();
		});
	}

	public function askAddress()
	{
		$this->ask('Where can we deliver your tasty pizza?', function($answer) {
			$this->address = $answer->getText();
			$this->say('Okay. That is all I need.');
			$this->say('Size: '.$this->size);
			$this->say('Topping: '.$this->topping);
			$this->say('Delivery address: '.$this->address);
		});
	}

}