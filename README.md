# SDsinghAssignment

Commands:  
php artisan migrate:reset                   <sub>// reset db</sub>  
php artisan migrate                         <sub>// create db</sub>  
php artisan db:seed                         <sub>// initialize data in all db</sub>  
php artisan db:seed --class=UsersSeeder     <sub>// initialize Users table</sub>   
php artisan db:seed --class=PricesSeeder    <sub>// initialize Prices table</sub>  
php artisan migrate:fresh --seed            <sub>// Reinitialize database and fill with mock values</sub>  
Output fake user accounts into fake_user_accs.txt  
  
TESTING:  
php artisan migrate:fresh --seed             <sub>// to generate db for testing</sub>  
vendor/bin/phpunit --coverage-html reports/  <sub>// for actual testing</sub>                                                                                                       
php artisan serve                            <sub>// to run server</sub> 

php artisan tinker                           <sub>// tinker command used when obtaining data from database</sub>  

User::all();                                 <sub>// used after using tinker command to get the user table data</sub>

QuoteHistory::all();                         <sub>// used after using tinker command to get QuoteHistory table data</sub>
