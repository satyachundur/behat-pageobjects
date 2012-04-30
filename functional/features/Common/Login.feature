#story1452
@javascript
Feature: Log in
    In order for people with access to use the tool for adding multiple overlays
    As an Implementation Manager
    I want a log-in function when I access VMS

    Background:
        Given I am on "/"

    Scenario: Successful log in
        And I am logged in as "test" with password "test"
        Then the logged in page displays
        Then I should see "Automated tester" on page

    Scenario: First time registration
        And I am logged in as "new" with password "new"
        Then the registration page displays
        Then I should see "register an account"

    Scenario: Incorrect username
        And I am logged in as "incorrect" with password "test"
        Then the registration page displays
        Then I should see "register an account"

    Scenario: Incorrect password
        And I am logged in as "test" with password "incorrect"
        Then the registration page displays
        Then I should see "register an account"


    #are there any username/password formats validation that needs testing?
