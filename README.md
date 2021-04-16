# EVENT MANAGEMENT SYSTEM


#### Following are the Models
* User
* EventRegistration
* EventLineup
* Ticket
* BookingHistory

#### Usage
Clone the project via git clone or download the zip file.

##### .env
Copy contents of .env.example file to .env file. Create a database and connect your database in .env file.
##### Composer Install
cd into the project directory via terminal and run the following  command to install composer packages.
###### `composer install`
##### Generate Key
then run the following command to generate fresh key.
###### `php artisan key:generate`
##### Run Migration and Seed
then run the following command to create migrations and create dummy content in  databbase.
###### `php artisan migrate:fresh --seed`

##### Generate secret key
###### `php artisan jwt:secret`

##### Run application
###### `php artisan serve`

#### Two user created
* admin user
  * username : admin
  * password : admin123
* user
  * username : user
  * password : admin123

### API EndPoints
##### User login
* User POST `http://127.0.0.1:8000/api/login`
##### Post
* POST  Event Registration `http://127.0.0.1:8000/api/register`
* GET  All Event ` http://127.0.0.1:8000/api/get-all-event`
* GET  Lineup By Event id `http://127.0.0.1:8000/api/get-lineup-by-event-id/id`
* POST Update Event `http://127.0.0.1:8000/api/update-event`
* POST Ticket Booking `http://127.0.0.1:8000/api/ticket-booking`
* GET  List Tickets `http://127.0.0.1:8000/api/get-ticket-details`
* GET  Dashboard statics `http://127.0.0.1:8000/api/get-tickets-statics`


