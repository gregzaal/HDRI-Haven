# HDRI Haven Source Code

This repo contains the website code for [HDRI Haven](https://hdrihaven.com/).

I am not a web developer really, so I apologize in advance for the hideous code you are about to see.

Contributions in the form of pull requests, bug reports or simply ideas are welcome.

To build the site you'll also need to clone the [Core Repo](https://github.com/gregzaal/Haven-Core) into a `core` subfolder, set up a MySQL database† and fill in the following info in `php/secret_config.php`:

```
$LOCAL_WORKING_FOLDER = "C:/foo/bar/";  // If working on a local machine (not webserver) set this to the root of where you cloned this repo.
$GEN_HASH_SALT = "qwertyuiop";  // Salt used for hash functions


// Database connections
$DB_SERV = "localhost";  // Url of your database
$DB_NAME = "dbname";  // Name of your database

$DB_USER = "";  // Read-write user
$DB_PASS = "";

$DB_USER_R = "";  // Read-only user
$DB_PASS_R = "";
```

† Right now there is no database schema available, but it should be easy enough to figure out what's required based on the error messages you get ;)
