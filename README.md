# Databrowser
## Installation
* Start XAMPP, and ensure Apache and MySQL servers are both running their respective servers
* Copy the entire `databrowser/`  folder into the root of Apache's configured host location
* Create a file named `dbcredentials.ini` at `databrowser/php/` containing the following:
    ```
    # username and password must be changed to match your database credentials
    # default MySQL port is 3306, but this may vary between systems
    server=localhost
    username=<your-db-username>
    password=<your-db-password>
    dbname=databrowser
    port=3306
    ```
* Visit `localhost/databrowser` in your browser
* All databases will be created (if they do not already exist) and populated with dummy data.
* **NOTE: YOUR APACHE SERVER MUST HAVE READ/WRITE ACCESS TO YOUR APACHE TEMP DIRECTORY. IMAGE UPLOADS WILL FAIL IF THIS IS NOT THE CASE WITH ERROR CODE 6 (TEMP DIRECTORY DOES NOT EXIST) AS IT CANNOT READ THE TEMP DIRECTORY AND THEREFORE CANNOT SEE IT.**