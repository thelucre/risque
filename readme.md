# Setup
* Get PHP dependencies with `composer install`
* Grab Node dependencies with `npm run npm`
* Run `php artisan key:generate`
* Add `.env` file with these settings:
	```
	DB_HOST=localhost

	DB_DATABASE=risque

	DB_USERNAME=root

	DB_PASSWORD=root
	```
* Add initial users with `php artisan db:seed --class=RegularUsers`
* Kickoff the FE build with `npm run watch`

* Use the data from `earth-map.json` for a single record in the `maps` table, or to inspect the data model for map editing. 
