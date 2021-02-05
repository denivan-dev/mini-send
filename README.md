### Installation
* composer install  
* php artisan storage:link  
###### Configure your environment
* php artisan migrate  
* npm run dev
### Run application
* php artisan serve  
  
###### If application uses a QUEUE_CONNECTION other than sync:
* php artisan queue:work  
### Run tests
* php artisan test
### Notes
Since API and frontend auth are not required  
i've made it single-user.
