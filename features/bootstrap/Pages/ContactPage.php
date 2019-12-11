<?php

namespace Pages;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class ContactPage extends Page
{
protected $path = '/login/';	
public function iFillInTheContactFormDetails()

  {

    $this->findField('Email:')->setValue('konradj@mail.com');
	  $this->findField('Password')->setValue('python');
  }
	
	
	
}