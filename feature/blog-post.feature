Feature: A user can create blog posts

  Scenario: an authenticated user can create blog posts
    Given an authenticated user
    When the user creates a new blog post
    Then the blog post can be viewed
    And the blog post author corresponds to the user that created it
