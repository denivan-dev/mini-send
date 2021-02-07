### Installation
* composer install  
* php artisan init 
###### Configure your environment, then:
* php artisan migrate  
* npm install
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
Each item in activities list refers to a view of single email.  
'To' field in email header refers to a list of emails for a recipient
