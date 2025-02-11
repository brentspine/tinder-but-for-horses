# Tinder But For Horses
Privately hostable tinder for small groups

## Features
 - Tinder like smash or pass
 - Customizable Admin Accounts
 - Profile with Firstname, Lastname, Bio and Class/Age
 - 3 Different Phases: Add Users, Tinder and Results
 - Admins can change phases and add users in the dashboard
 - Custom welcome page explaining everything for new users
 - [Tutorial Video](https://github.com/brentspine/tinder-but-for-horses/blob/main/images/Tinder_Tutorial.mp4)
 
 ## Phases
 
 ### Add users
 This is the phase, where noone is able to vote yet. It should be used during the time admins set up accounts and give out login details.
 
 ### Tinder
 This is the phase inwhich the students can use the tinder as normal. On the `/hub` page there will be a suggestion that can be marked as smash or as pass by the user. They can also reroll the suggestion if they aren't sure. At the bottom of the page they can check all their past votes and delete them. \
 Students can not exceed a set limit of likes, so they can't mark everyone as smash.
   
 ### Results
 When this phase gets enabled students who participated will be able to see their matches on the main page along with some general stats about the tinder round. 
 
 
 ## Setup
 This was a private project for a friend but I decided to publish the project so anyone can reuse it. 
 
 1. Find a hosting service, that supports MySQL and PHP. The server doesn't have to be highend.
 2. Ensure you have installed git on your PC
 3. Afer you have purchased the webspace clone the GitHub project to your desktop by opening a command prompt there and running `git clone https://github.com/brentspine/tinder-but-for-horses`
 4. Make sure your webpage is accessible in the first place
 5. Connect to your server via FTP, you should have received the login details for that. Otherwise there should be an option on your dashboard on the providers website.
 6. Move the contents of the generated folder from your desktop to the path dedicated to the webpage on the server via FTP.
 
 ### Database
 When running the project for my school I used a MySQL Database backend, for which the database setup file is built. \
 Here is what you have to do:
  1. Go to the database setup on your hosting website
  2. Go to the page onwhich you can run SQL Code (e.g. phpMyAdmin)
  3. Copy and paste the content of the [database.sql](https://github.com/brentspine/tinder-but-for-horses/blob/main/database.sql) file and run the code
  4. Enter the SQL connection details in the [connection.php](https://github.com/brentspine/tinder-but-for-horses/blob/main/include/connection.php) file
  5. Customize the messages displayed in the `json_codes` table
  6. Change the admin password in the `users` table
  
 ### Changing details
 There might be some details on the webpage that have to be changed, like placing your logo as `logo.png` into the `/images` subpath or changing the text on the bottom right in the footer.
 
 ### Adding users
 Now when everything else is set-up it's time to add users. \ 
 Here is what you have to do:
  0. (Make sure the "Add users" phase is set)
  1. Log into your admin account
  2. Go the dashboard that can be found on the top right
  3. Click on "Add users"
  4. Enter the students details, the username will be automatically filled out when adding first and lastname
  5. Press Save
  6. Copy the password and give it to the person the account was created for
  
### Starting the tinder
 1. Log into your admin account
 2. Go the dashboard that can be found on the top right
 3. Click on "Change Phase"
 4. Select a "Poll" from the dropdown menu and click save.
 
 ### Publishing the results
 1. Log into your admin account
 2. Go the dashboard that can be found on the top right
 3. Click on "Change Phase"
 4. Select a "Results" from the dropdown menu and click save.
