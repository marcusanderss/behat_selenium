<?php
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Pages\ProductPage;
use Pages\HomePage;
use Pages\ContactPage;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
	 /**
     * @var ProductPage
     */
    private $productPage;
    private $hemsida;
    private $kontakt;

    public function __construct(HomePage $hemsida, ProductPage $productPage, ContactPage $kontakt)
    {
        $this->hemsida = $hemsida;
        $this->productPage = $productPage;
        $this->kontakt = $kontakt;
    }
	
	
  /**
   * Waits a while, for debugging.
   *
   * @param int $seconds
   *   How long to wait.
   *
   * @When I wait :seconds second(s)
   */
  public function wait($seconds) {
    sleep($seconds);
  }
	
    /**
     * @When I fill in correct information and submit the form
     */
    public function iFillInCorrectInformationAndSubmitTheForm()
    {
        
    }

	/**
     * @Given /^(?:|I )visited (?:|the )(?P<pageName>.*?)$/
     */
    public function iVisitedThe($pageName)
    {
     if (!isset($this->$pageName)) {
     throw new \RuntimeException(sprintf('Unrecognised page: "%s".', $pageName));
    }
    $this->$pageName->open();
    }
	
	/**
     * @Given I select ELECTRONICS
     */
    public function iGoToStödOchVerktyg()
    {
    $this->hemsida->findLink("Stöd och verktyg")->click();
    }
	
	
	/**
     * @Given /^I select "([^"]*)"$/
     */
    public function iSelectElectronics()
    {
    iClickOnTheElementWithXPath("//a[contains(text(),\'Electronics\')]");
    }
	
	
	/**
     * @Given /^I go to sida "([^"]*)"$/
     */
    public function iGoToSida($css_selector)
    {
    $this->hemsida->findLink($css_selector)->click();
    }
	
	/** Click the element with CSS selector ".something-clickable"
	 *
     * @When /^(?:|I )click the element with CSS selector "([^"]*)"$/
     */
    public function iClickTheElementWithCssSelector($css_selector) 
	{
        $element = $this->getSession()->getPage()->find("css", $css_selector);
          if (empty($element)) {
          throw new \Exception(sprintf("The page '%s' does not contain the css selector '%s'", $this->getSession()->getCurrentUrl(), $css_selector));
          }
		  
	// ok, let's click on it
    $element->click();
	
    }

    /**
     * @Then I click the element with link_text :arg1
     */
    public function iClickTheElementWithLinkText($arg1)
    {
        $element = $this->getSession()->getPage()->findLink($arg1);
          if (empty($element)) {
          throw new \Exception(sprintf("The page '%s' does not contain the link_text '%s'", $this->getSession()->getCurrentUrl(), $css_selector));
          }
		  
	// ok, let's click on it
    $element->click();
    }
	
	/**
     * @Then I should see the CSS selector :arg1
     */
    public function iShouldSeeTheCssSelector($css_selector)
    {
		$element = $this->getSession()->getPage()->find("css", $css_selector);
		if (empty($element)) {
		throw new \InvalidArgumentException(sprintf("The page '%s' does not contain the css selector '%s'", $this->getSession()->getCurrentUrl(), $css_selector));
        }
	}
	
	/**
     * @Then I should not see the CSS selector :arg1
     */
    public function iShouldNotSeeTheCssSelector($css_selector)
    {
        $element = $this->getSession()->getPage()->find("css", $css_selector);
        if (!empty($element)) {
        throw new \Exception(sprintf("The page '%s' contains the css selector '%s'", $this->getSession()->getCurrentUrl(), $css_selector));
       }
    }

	
	/** Click on the element with the provided xpath query
     *
     * @When /^I click on the element with xpath "([^"]*)"$/
     */
    public function iClickOnTheElementWithXPath($xpath)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find(
            'xpath',
        $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
    ); // runs the actual query and returns the element

    // errors must not pass silently
    if (null === $element) {
        throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
    }

    // ok, let's click on it
    $element->click();

    }

    /**
     * @When I wait for :text to appear
     * @Then I should see :text appear
     * @param $text
     * @throws \Exception
     */
    public function iWaitForTextToAppear($text)
    {
        $this->spin(function(FeatureContext $context) use ($text) {
            try {
                $context->assertPageContainsText($text);
                return true;
            }
            catch(ResponseTextException $e) {
                // NOOP
            }
            return false;
        });
    }


    /**
     * @When I wait for :text to disappear
     * @Then I should see :text disappear
     * @param $text
     * @throws \Exception
     */
    public function iWaitForTextToDisappear($text)
    {
        $this->spin(function(FeatureContext $context) use ($text) {
            try {
                $context->assertPageContainsText($text);
            }
            catch(ResponseTextException $e) {
                return true;
            }
            return false;
        });
    }

    /**
     * Based on Behat's own example
     * @see http://docs.behat.org/en/v2.5/cookbook/using_spin_functions.html#adding-a-timeout
     * @param $lambda
     * @param int $wait
     * @throws \Exception
     */
    public function spin($lambda, $wait = 30)
    {
        $time = time();
        $stopTime = $time + $wait;
        while (time() < $stopTime)
        {
            try {
                if ($lambda($this)) {
                    return;
                }
            } catch (\Exception $e) {
                // do nothing
            }

            usleep(5000);
        }

        throw new \Exception("Spin function timed out after {$wait} seconds");
    }

    /**
     * @Then page should have body class :text 
     * @param $text
     * @throws \Exception
     */
    public function pageShouldHaveBodyClass($text)
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $el = $page->find('css', 'body');
        try {
            $outer = $el->getOuterHtml();
            if ($el->hasClass($text)) {
                return;
            }
        } catch (\Exception $e) {
            // do nothing
        }

        throw new \Exception ("Body does not have {$text} class.");
    }
}