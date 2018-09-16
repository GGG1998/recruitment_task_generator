#Recruiment task in Symfony 4
Web application to generate and manage unique codes.  
**List of codes** shows value of key and date create. There are two options _generate_ and _remove_
**Generate view** shows 10 codes which was generated  
**Remove view** shows form to put codes to remove if code is incorrect then will show exception

##How it's run?
     git clone PLACE TO MY URL URL
Inside root project to install dependencies

     php composer.phar install
Open file **_.env_** in root project

    # customize this line!
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/codes"
Open console in root project
       
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    php bin/console server:run 127.0.0.1:8000