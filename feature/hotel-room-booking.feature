Feature: Rooms can be booked

  Background:
    Given following room availability:
      | Room number | Date | Price (EUR) | Maximum PAX |
      | 101         | 2017-06-01 | 100   | 2           |
      | 101         | 2017-06-02 | 105   | 2           |
      | 101         | 2017-06-03 | 103   | 2           |
      | 101         | 2017-06-04 | 110   | 2           |
      | 102         | 2017-06-01 | 100   | 2           |
      | 102         | 2017-06-02 | 105   | 2           |
      | 102         | 2017-06-03 | 103   | 2           |
      | 102         | 2017-06-04 | 110   | 2           |
      | 103         | 2017-06-01 | 200   | 4           |
      | 103         | 2017-06-02 | 210   | 4           |
      | 103         | 2017-06-03 | 206   | 4           |
      | 103         | 2017-06-04 | 220   | 4           |
      | 104         | 2017-07-01 | 200   | 4           |
      | 104         | 2017-07-02 | 210   | 4           |
      | 104         | 2017-07-04 | 220   | 4           |
    And "Leia Organa" <admin@the-rebellion.org> is a registered user
    And a tax rate of 7%

  Scenario: successful room reservation
    When "Leia Organa" reserves a room for 2 people for the period 2017-06-02~2017-06-04
    Then "Leia Organa" has been charged 340.26 EUR
    And "Leia Organa" has been sent a confirmation for a reservation for room 101 for the period 2017-06-02~2017-06-04
    And the rooms available for the period 2017-06-02~2017-06-04 became:
      | Room number |
      | 102         |
      | 103         |

  # scenario proposals here:

