## Movie Review API

Welcome to Movie Review API Application. This API manages CRUD opertions. Below are the features of this application.
- users can submit and view Reviews
- users can register and this API is protected by laravel passport
- users can search movies by genre or title
- email will be sent to admin on every successful registration
- emails will be sent to users everyday to notify them on the new videos added
### Environmental Requirement

-   PHP ^8.2
-   composer

### Installation

-   run "composer install"
-    "edit .env according to requirement - (datasection, mail..)"

### Set up for laraval passport authenticator

-   run "php artisan migrate"
-   run "php artisan dbc:seed "
-   run "php artisan passport:keys "

 ### Admin Details
 -   admin@gmail.com
 -   password 

 ### Run Test
