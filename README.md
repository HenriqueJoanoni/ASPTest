## Instalation
You can clone this repository or download the .zip

After clone/unzip it's necessary run **composer** to install all the dependencies and generate the *autoload*.

Go to the directory project and execute from your *prompt/terminal*:
> composer install

After that, just wait

## Configuring
All helper files are in the *helpers* folder.

The main functions are located in the *src* folder.

## Database
The database structure dump file is located in the **essentials** folder.

**ps:** add your database credentials on the connection string in: *helpers/Database.php*

## Usage
To use this cli, you need to call on your command line:

#### To create a new user:
> ./asp-test USER:CREATE

Then follow the instructions

#### To update a user:
> ./asp-test USER:UPDATE {USERID}
