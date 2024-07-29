# PHP test

## 1. Installation

  - create an empty database named "phptest" on your MySQL server
  - import the dbdump.sql in the "phptest" database
  - put your MySQL server credentials in the constructor of DB class
  - you can test the demo script in your shell: "php index.php"

## 2. Expectations

This simple application works, but with very old-style monolithic codebase, so do anything you want with it, to make it:

  - easier to work with
  - more maintainable

Changes Made:
- Data type on News and Comment class properties and methods
- Dependency Injection
- NewsManager and CommentManager extends DB to inherit its dependencies
- Parameterized SQLs
- Some behavioral changes (esp. showing comments)
- Added relation on comment.news_id to news.id and cascades when deleted