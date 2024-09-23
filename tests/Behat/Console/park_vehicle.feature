Feature: Execute fleet:park-vehicle command

  I should be able to park a vehicle to a location from a cli

  Scenario: Execute successfully
    Given I run console command "fleet:create JohnDoe"
    And I run console command "fleet:register-vehicle 1 GG-123-WP"
    When I run console command "fleet:park-vehicle GG-123-WP 43.455252 5.475261"
    Then the output should contain:
    """
    Vehicle successfully parked.
    """

  Scenario: Execute fail
    Given I run console command "fleet:create JohnDoe"
    And I run console command "fleet:register-vehicle 1 GG-123-WP"
    And I run console command "fleet:park-vehicle GG-123-WP 43.455252 5.475261"
    When I run console command "fleet:park-vehicle GG-123-WP 43.455252 5.475261"
    Then the output should contain:
    """
    Vehicle with id "GG-123-WP" is already parked at location.
    """

  Scenario: Execute with a non existing vehicle
    When I run console command "fleet:park-vehicle GG-123-WP 43.455252 5.475261"
    Then the output should contain:
    """
    App\Domain\Model\Vehicle" with id "GG-123-WP" not found.
    """
