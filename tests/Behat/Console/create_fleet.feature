Feature: Execute fleet:create command

  I should be able to create a fleet from a cli

  Scenario: Execute successfully
    Given I run console command "fleet:create JohnDoe"
    Then the output should contain:
    """
    Fleet created.
    Fleet id:
    """

  Scenario: Execute with an invalid arg
    Given I run console command "fleet:create"
    Then the output should contain:
    """
    Parameter "userId" must be a non empty string.
    """

  Scenario: Execution fail
    Given I run console command "fleet:create JohnDoe"
    Then I run console command "fleet:create JohnDoe"
    Then the output should contain:
    """
    Fleet already exist.
    """
