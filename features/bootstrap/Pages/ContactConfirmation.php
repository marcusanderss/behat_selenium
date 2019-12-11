<?php

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;


class ContactConfirmation extends Page

{

  /**

   * @Then /^I should be able to see the message$/

   */

  public function iShouldBeAbleToSeeTheMessage()

  {

      $this->hasContent("Thank You for Contacting Axelerant");

  }

}