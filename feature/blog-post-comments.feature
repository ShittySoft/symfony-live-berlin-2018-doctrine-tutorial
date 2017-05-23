Feature: Users can comment on blog posts of other users

  Scenario: an authenticated user can comment on a blog post
    Given an authenticated user and an existing blog post by another user
    When the user comments on the blog post
    Then the blog post comment can be viewed

  Scenario: the author of a blog post cannot comment on the blog post
    Given an authenticated user and an existing blog post by the same user
    Then the user cannot comment on the blog post

  Scenario: view most commented blog posts
    Given an existing set of blog posts with comments
    When I view the list of commented blog posts
    Then the list of popular commented  blog posts should be sorted by comment count
    And the list of popular commented blog posts should be paginated
