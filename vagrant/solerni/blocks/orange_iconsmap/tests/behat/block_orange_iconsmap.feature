@block @block_orange_iconsmap
Feature: Block_orange_iconsmap
  In order to overview extended informations for a course
  As a user
  I can see extended values for a course in find out more page

  Background:
    Given I log in as "user"
    And I navigate to "my moocs" blocks
    And I wait over the "course block"
    And I see the roll over
    And I click on "find out more" link

  Scenario: Add activities block on the /mooc/view page
    Given the following "blocks" exist:
      | block      | name                        | intro                              | course               | idnumber    |
      | orange_action     | Frontpage assignment name   | Frontpage assignment description   | Acceptance test course | assign0     |
      | orange_iconsmap       | Frontpage book name         | Frontpage book description         | Acceptance test site | book0       |
      | orange_separator_line       | Frontpage chat name         | Frontpage chat description         | Acceptance test site | chat0       |
      | orange_social_sharing     | Frontpage choice name       | Frontpage choice description       | Acceptance test site | choice0     |
      | orange_paragraph_list       | Frontpage database name     | Frontpage database description     | Acceptance test site | data0       |

    And I am on site homepage
    When I follow "Turn editing on"
    And I add the "Activities" block
    And I click on "Assignments" "link" in the "Activities" "block"
    Then I should see "Frontpage assignment name"
    And I am on site homepage
    And I click on "Chats" "link" in the "Activities" "block"
    And I should see "Frontpage chat name"
    And I am on site homepage
    And I click on "Choices" "link" in the "Activities" "block"
    And I should see "Frontpage choice name"
    And I am on site homepage
    And I click on "Databases" "link" in the "Activities" "block"
    And I should see "Frontpage database name"
    And I am on site homepage
    And I click on "Feedback" "link" in the "Activities" "block"
    And I should see "Frontpage feedback name"
    And I am on site homepage
    And I click on "Forums" "link" in the "Activities" "block"
    And I should see "Frontpage forum name"
    And I am on site homepage
    And I click on "External tools" "link" in the "Activities" "block"
    And I should see "Frontpage lti name"
    And I am on site homepage
    And I click on "Quizzes" "link" in the "Activities" "block"
    And I should see "Frontpage quiz name"
    And I am on site homepage
    And I click on "Glossaries" "link" in the "Activities" "block"
    And I should see "Frontpage glossary name"
    And I am on site homepage
    And I click on "SCORM packages" "link" in the "Activities" "block"
    And I should see "Frontpage scorm name"
    And I am on site homepage
    And I click on "Lessons" "link" in the "Activities" "block"
    And I should see "Frontpage lesson name"
    And I am on site homepage
    And I click on "Wikis" "link" in the "Activities" "block"
    And I should see "Frontpage wiki name"
    And I am on site homepage
    And I click on "Workshop" "link" in the "Activities" "block"
    And I should see "Frontpage workshop name"
    And I am on site homepage
    And I click on "Resources" "link" in the "Activities" "block"
    And I should see "Frontpage book name"
    And I should see "Frontpage page name"
    And I should see "Frontpage resource name"
    And I should see "Frontpage imscp name"
    And I should see "Frontpage folder name"
    And I should see "Frontpage url name"

  Scenario: Add activities block in a course
    Given the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "activities" exist:
      | activity   | name                   | intro                         | course | idnumber    |
      | assign     | Test assignment name   | Test assignment description   | C1     | assign1     |
      | book       | Test book name         | Test book description         | C1     | book1       |
      | chat       | Test chat name         | Test chat description         | C1     | chat1       |
      | choice     | Test choice name       | Test choice description       | C1     | choice1     |
      | data       | Test database name     | Test database description     | C1     | data1       |
      | feedback   | Test feedback name     | Test feedback description     | C1     | feedback1   |
      | folder     | Test folder name       | Test folder description       | C1     | folder1     |
      | forum      | Test forum name        | Test forum description        | C1     | forum1      |
      | glossary   | Test glossary name     | Test glossary description     | C1     | glossary1   |
      | imscp      | Test imscp name        | Test imscp description        | C1     | imscp1      |
      | label      | Test label name        | Test label description        | C1     | label1      |
      | lesson     | Test lesson name       | Test lesson description       | C1     | lesson1     |
      | lti        | Test lti name          | Test lti description          | C1     | lti1        |
      | page       | Test page name         | Test page description         | C1     | page1       |
      | quiz       | Test quiz name         | Test quiz description         | C1     | quiz1       |
      | resource   | Test resource name     | Test resource description     | C1     | resource1   |
      | scorm      | Test scorm name        | Test scorm description        | C1     | scorm1      |
      | survey     | Test survey name       | Test survey description       | C1     | survey1     |
      | url        | Test url name          | Test url description          | C1     | url1        |
      | wiki       | Test wiki name         | Test wiki description         | C1     | wiki1       |
      | workshop   | Test workshop name     | Test workshop description     | C1     | workshop1   |

    When I follow "Courses"
    And I follow "Course 1"
    And I turn editing mode on
    And I add the "Activities" block
    And I click on "Assignments" "link" in the "Activities" "block"
    Then I should see "Test assignment name"
    And I follow "Course 1"
    And I click on "Chats" "link" in the "Activities" "block"
    And I should see "Test chat name"
    And I follow "Course 1"
    And I click on "Choices" "link" in the "Activities" "block"
    And I should see "Test choice name"
    And I follow "Course 1"
    And I click on "Databases" "link" in the "Activities" "block"
    And I should see "Test database name"
    And I follow "Course 1"
    And I click on "Feedback" "link" in the "Activities" "block"
    And I should see "Test feedback name"
    And I follow "Course 1"
    And I click on "Forums" "link" in the "Activities" "block"
    And I should see "Test forum name"
    And I follow "Course 1"
    And I click on "External tools" "link" in the "Activities" "block"
    And I should see "Test lti name"
    And I follow "Course 1"
    And I click on "Quizzes" "link" in the "Activities" "block"
    And I should see "Test quiz name"
    And I follow "Course 1"
    And I click on "Glossaries" "link" in the "Activities" "block"
    And I should see "Test glossary name"
    And I follow "Course 1"
    And I click on "SCORM packages" "link" in the "Activities" "block"
    And I should see "Test scorm name"
    And I follow "Course 1"
    And I click on "Lessons" "link" in the "Activities" "block"
    And I should see "Test lesson name"
    And I follow "Course 1"
    And I click on "Wikis" "link" in the "Activities" "block"
    And I should see "Test wiki name"
    And I follow "Course 1"
    And I click on "Workshop" "link" in the "Activities" "block"
    And I should see "Test workshop name"
    And I follow "Course 1"
    And I click on "Resources" "link" in the "Activities" "block"
    And I should see "Test book name"
    And I should see "Test page name"
    And I should see "Test resource name"
    And I should see "Test imscp name"
    And I should see "Test folder name"
    And I should see "Test url name"
