## PRUnderground Frontend Assessment

If you've made it here, we're really excited about potentially working with you!
This assessment is to gauge your ability to:

- Familiarity with Git workflows (clones, commits, pull requests, etc.)
- Quickly get up and running in a new codebase
- Turn requirements into code changes
- Create custom plugins to accomplish common frontend tasks.

## Installation

1. Use this repo as template, and add "beeze" and "eczeki" as collaborators in your new project.
2. Install Composer: https://getcomposer.org/download/
3. Create your project

```
composer create-project johnpbloch/wordpress-project [YOUR-NAME]-assessment
```

This will create the project in the `[YOUR-NAME]-assessment` directory. The project uses `public` as the document root, so make sure to take that into account in your host configurations.

4. Go into the `[YOUR-NAME]-assessment` that was created after executing the composer command. Then go into `public/wp`.
5. Download the wp-config-sample.php file: https://github.com/WordPress/WordPress/blob/master/wp-config-sample.php
6. Rename `wp-config-sample.php` inside `[YOUR-NAME]-assessment/public/wp` to `wp-config.php`
7. Install MySQL locally and create a new database
8. Edit wp-config.php and modify DB_NAME to point to the DB you create in step 7, DB_USER is your MySQL user, DB_PASSWORD is your MySQL password, DB_HOST can be localhost
9. Start the PHP development server: `php -S localhost:8080`. You have to do this within `[YOUR-NAME]-assessment/public/wp`

## Coding Challenge

### Background
The team identified that people aren’t signing up to our newsletter as frequently as they should so they decided that they need to make the newsletter opt-in way more visible to the users.

https://imgur.com/a/az4IIIf

This modal should follow the user’s viewpoint consistently positioned in the middle of the screen. Please make sure the design matches the image provided.

### Acceptance Criteria

* Make sure the modal follows the user viewpoint as he scrolls through the site and it’s centered in the middle of the screen
* Users can’t submit the form with empty fields
* Once signup is clicked record the users name and email in a database table specific to the newsletter
* Once signup is clicked close the modal 
* Don’t show the modal again on page refresh after the user has already submitted the form
* Include a shadow behind the modal
* Make sure the modal is visible in all pages after the plugin is activated

Please don’t install any libraries.

Also note that your use of git commits and version control will be included in our assessment of your work.
