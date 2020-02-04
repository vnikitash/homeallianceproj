What has been added:<br>
- DTOs - Data Transfer objects. This objects accepted by Services and created by FromRequests. We need them as Services should know how to work not only with HTTP requests, but as CLI tools, jobs etc... You can find them under app/DTO namespace<br>
- Services - We need them to have only 1 interface of business logic for the whole application. For example if we have mobile app, web app, cli scripts etc. We need to have the same features behaviour for each of them, like user registration etc<br>
- Repositories - Third custom layer added for working ith CRUD operations, as good idea to have centralized place of working with data<br>
- Localization - by the <b>Accept-Language</b> header you can chose language of the BackEnd app. This example has only two supported languages: <i>de</i> and <i>en</i><br>
- API endpoints: register user, login user, get current user<br>
For user registration send request via POSTman or whatever you want data to the next endpoint:<br>
`POST http://localhost/api/register` <br>
And send next data:
```
{
   	"email": "demo@user.example",
   	"password": "password",
   	"password_confirmation": "password",
   	"first_name": "Viktor",
   	"last_name": "Nikitash"
}
```
For login:
`POST http://localhost/api/login` <br>
And send next data:
```
{
   	"email": "demo@user.example",
   	"password": "password"
}
```
For getting information about user:<br>
`GET http://localhost/api/user` <br>
And send next header:
`Authorization: Bearer ***TOKEN***`<br>
Token obtaining after <b>login</b><br><br>
- API Tests with Codeception framework. For running them, just call command `php vendor/bin/codecept run -d`<br>
- Docker compose file, which initiates base architecture<br><br>
P.S For setting up project just install Docker into your machine and execute command `sh setup.sh` in project directory. All required installations will be executed automatically<br>
This command all what you need to test everything<br>
Please note that tests will start to work, only when main PHP container will install all of the dependencies, before this time, homealliance-php-tests container will show that autoload.php file not found (as main php container need time to install composer dependencies)