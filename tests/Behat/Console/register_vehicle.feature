Feature: Execute fleet:register-vehicle command

  I should be able to create and register a vehicle into an existing fleet from a cli

  Scenario: Execute successfully
    Given I run console command "fleet:create JohnDoe"
    When I run console command "fleet:register-vehicle 1 GG-123-WP"
    Then the output should contain:
    """
    Vehicle successfully registered.
    """

  Scenario: Execute with invalid fleetId
    Given I run console command "fleet:register-vehicle"
    Then the output should contain:
    """
    Parameter "fleetId" must be a positive integer.
    """

  Scenario: Execute with an empty plate number
    Given I run console command "fleet:register-vehicle 1"
    Then the output should contain:
    """
    Parameter "vehiclePlateNumber" must be a non empty string.
    """

  Scenario: Execute with an invalid plate number
    Given I run console command "fleet:create JohnDoe"
    When I run console command "fleet:register-vehicle 1 test"
    Then the output should contain:
    """
    "test" is not a valid vehicle plate number.
    """

  Scenario: Execute with a non existing fleet
    Given I run console command "fleet:register-vehicle 1 GG-123-WP"
    Then the output should contain:
    """
    App\Domain\Model\Fleet" with id "1" not found.
    """

  Scenario: Execute with an already registered vehicle
    Given I run console command "fleet:create JohnDoe"
    Then I run console command "fleet:register-vehicle 1 GG-123-WP"
    When I run console command "fleet:register-vehicle 1 GG-123-WP"
    Then the output should contain:
    """
    Vehicle "GG-123-WP" is already registered.
    """

  Scenario: Register a vehicle in multiple fleet
    Given I run console command "fleet:create JohnDoe"
    And I run console command "fleet:register-vehicle 1 GG-123-WP"
    And I run console command "fleet:create JaneDoe"
    When I run console command "fleet:register-vehicle 2 GG-123-WP"
    Then the output should contain:
    """
    Vehicle successfully registered.
    """
