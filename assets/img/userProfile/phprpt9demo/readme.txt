PHP Report Maker 9 Demo Project Readme File

1. Install PHP Report Maker 9,
2. Unzip the demo archive to any folder,
3. Create the demo databases in your MySQL server:
- import the "demorpt" database using the SQL script demorpt9.sql
- import the "demo2" database using the SQL script demo2.sql (this is just a part of demorpt9.sql for testing Linked Table only)
4. Open the demo project, demo9.prp with PHP Report Maker, Change the connection info and save the project if necessary:
- change the connection info in the [Database] tab, click "Tools"->"Synchronize" to update the main database connection info,
- click "Edit"->"Add Linked Tables", select "demo (var: demo2, type: MySQL)" from the Database selection list (error may occur because the username and password are incorrect, ignore it),
- click the "Synchronize" button to update the database connection info and then click "OK' to close the form
5. Click on the "Generate" tab, change the application root folder and destination folder to where you want to output the generated files,
6. If you have IIS Express installed on your machine and use it as testing Web server, check "Browse after generation",
7. Click the "Generate" button,
8. Browse the generated website.