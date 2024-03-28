# Final Project UTN Advanced PHP and MySQL Course

## Tools Used in the Project

- Html and Css for page layout and design.
- PHP for server-side logic and database interaction using PDO and prepared statements.
- Ajax for client-side POST requests.

## Database Configuration

The project consists of two tables, users and user_logs.
   * users: It has 7 fields: id, name, email, password, connected, created_at, and updated_at.
   * user_logs: It has 5 fields: id, user_id, action, created_at, and updated_at.

The user_logs table has the user_id field, which is a foreign key associated with the id of the users table, establishing a relationship between the users table and user_logs.

## General Logic

The project has an index.php file where different project configuration files are included, errors are activated or deactivated, the session is started, and the RouteController is called, which is responsible for managing user actions based on the type of method it receives. It only handles GET and POST requests; any other method results in a 405 error code (method not allowed).
When a user first enters the page, they are taken to the Login section to log in through a form if they are registered in the database. Otherwise, they can access Register to create a user and be registered in the database.
Once logged in or registered, a session is created for the user, and they are taken to the [Users](#users) section, which consists of a table with the latest users who had some type of update in the database. From there, they can access two other sections: [User Logs](#user-logs) and [Profile](#profile).
Finally, there is a [Logout](#logout) button, which destroys the user's session, saves a record that the user closed the session, and takes them back to the login page.

## Project Sections

- ### Home

  Home has two forms: Register and Login, both using AJAX to make server requests using the POST method.

  - #### Register Form

    Used to store a new user in the database and has 3 fields: Name, Email, and Password. If the fields are correctly [validated](#field-validation) by the RegisterController, it creates a session for the user, saves the new user in the database, creates a user log indicating that the user was created, and redirects the user to the [Users](#users) section.

  - #### Login Form

    Used for a user who is already registered in the database to log in to the site. It has two fields: Name and Password. If the fields are correctly [validated](#field-validation) by the LoginController, it creates a session for the user, creates a user log indicating that the user accessed the site, changes the connected field in the users table to 1 for the logged-in user, and redirects the user to the [Users](#users) section.

- ### Users

  Users is a table showing a list of the latest users (limited to 50) who have received an update in their records in the users table.

- ### User Logs

  Consists of a table showing records (limited to 30) from the user_logs table related to the user, displaying the actions performed by the user (creating the user, logging into the site, and closing the session), along with the date and time they occurred.

- ### Profile

  Displays basic user data: Name, Email, connection status, and the last time the user's record in the users table was updated. It also contains the `Delete Account` button, which redirects to a section to confirm if the user wants to delete their account from the site and remove the user from the database.

- ### Logout

  The logout button allows the user to log out of the site, destroying the user's session. It leaves a record in the user_logs table that the user closed the session and changes the connected field of the user to 0 in the users table. Once all this is done, the user is redirected to the login page.

- ### Errors 
  If the page route is not found, a 404 error screen is displayed. In case of a server-side error, the user is redirected to a 500 error page.

## Field Validation

The fields of the [Register](#register-form) and [Login](#login-form) forms are validated server-side using the ValidatorController in their respective controllers, which carry out queries to the database.

- ### Name Field

    * Always required; it cannot be an empty input.
    * Spaces or special characters are not allowed.
    * The number of characters must be between 5 and 25.
    * In the case of the [Register](#register-form) form, a query is made to the database to verify that the name does not already exist in the users table since the Name is unique for each user.

- ### Email Field

    * Always required; it cannot be an empty input.
    * Must be in email format.
    * The number of characters must be between 10 and 50.

- ### Password Field

    * Always required; it cannot be an empty input.
    * The number of characters must be between 5 and 50.
