Feature: Första beta versionen med page objects

@javascript
Scenario: Logga in på webshop, beställ en produkt, logga ut
Given I am on "/"
Then I should see "Log in"
And I should not see "Email:"
And I should not see "Log out"
And I go to sida "Log in"
And I should see "Email:"
And I should see "Password:"
And I fill in "konradj@mail.com" for "Email:"
And I fill in "python" for "Password:"
Then the "Email:" field should contain "konradj@mail.com"
And the "Password:" field should contain "python"
When I press "Log in"
Then I should see "Log out"
And I should see "ELECTRONICS"
Given I go to "/electronics"
And I should see "Cell phones"
Given I go to "/cell-phones"
And I go to "/smartphone"
Then the "Qty:" field should contain "1"
And I press "Add to cart"
And I go to "/cart"
And I should see "Shopping cart"
And I wait for "I agree with the terms of service and I adhere to them" to appear
When I check "termsofservice"
And I press "Checkout"
Then I should see "Billing Address"
And I should see "Konrad Jönsson, Grisbacka 34, Umeå 1425767, Sweden"
And I press "Continue"
Then I should see "Shipping Address"
And I wait 1 seconds
And I check "In-Store Pickup"
And I wait 1 seconds
And I click the element with CSS selector ".new-address-next-step-button:nth-child(2)"
And I should see "Payment Method"
And I click the element with CSS selector ".payment-method-next-step-button"
And I wait for "Payment Information" to appear
And I click the element with CSS selector ".payment-info-next-step-button"
And I wait for "Confirm Order" to appear
And I click the element with CSS selector ".confirm-order-next-step-button"
Then I should see "Billing Address"
And I should see "Konrad Jönsson"
And I wait 1 seconds
And I click the element with CSS selector ".button-2"
And I wait 1 seconds
Then I click the element with link_text "Log out"
And I wait for "Log in" to appear






