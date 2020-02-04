<?php

use Codeception\Util\Shared\Asserts;

class TestDemoCest
{
    use Asserts;

    public function testRegisterUser(ApiTester $I)
    {
        $userName = "Demo";
        $userLastName = "Tester";
        $userEmail = "email+" . time() . "+" . rand(1,1000) .  "@email.com";
        $userPassword = "password";

        $I->sendPOST('/api/register', [
            'first_name' => $userName,
            'last_name' => $userLastName,
            'email' => $userEmail,
            'password' => $userPassword,
            'password_confirmation' => $userPassword,
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Illuminate\Http\Response::HTTP_CREATED);
        $res = json_decode($I->grabResponse(), true);

        $this->assertTrue($res['status']);
    }

    public function testRegisterNonUniqueUser(ApiTester $I)
    {
        $userName = "Demo";
        $userLastName = "Tester";
        $userEmail = "email+" . time() . "+" . rand(1,1000) .  "@email.com";
        $userPassword = "password";

        $I->sendPOST('/api/register', [
            'first_name' => $userName,
            'last_name' => $userLastName,
            'email' => $userEmail,
            'password' => $userPassword,
            'password_confirmation' => $userPassword,
        ]);

        $I->sendPOST('/api/register', [
            'first_name' => $userName,
            'last_name' => $userLastName,
            'email' => $userEmail,
            'password' => $userPassword,
            'password_confirmation' => $userPassword,
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Illuminate\Http\Response::HTTP_BAD_REQUEST);
    }

    public function testLoginUser(ApiTester $I)
    {
        $userName = "Demo";
        $userLastName = "Tester";
        $userEmail = "email+" . time() . "@email.com";
        $userPassword = "password";

        //Could be replaced by faker
        $I->sendPOST('/api/register', [
            'first_name' => $userName,
            'last_name' => $userLastName,
            'email' => $userEmail,
            'password' => $userPassword,
            'password_confirmation' => $userPassword,
        ]);

        $I->sendPOST('/api/login', [
            'email' => $userEmail,
            'password' => $userPassword
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Illuminate\Http\Response::HTTP_OK);
        $I->seeResponseJsonMatchesJsonPath('$.accessToken');
    }

    public function testUserInfoRequest(ApiTester $I)
    {
        $userName = "Demo";
        $userLastName = "Tester";
        $userEmail = "email+" . time() . "@email.com";
        $userPassword = "password";

        //Could be replaced by faker
        $I->sendPOST('/api/register', [
            'first_name' => $userName,
            'last_name' => $userLastName,
            'email' => $userEmail,
            'password' => $userPassword,
            'password_confirmation' => $userPassword,
        ]);

        $I->sendPOST('/api/login', [
            'email' => $userEmail,
            'password' => $userPassword
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Illuminate\Http\Response::HTTP_OK);

        $token = \Illuminate\Support\Arr::get(json_decode($I->grabResponse(), true), 'accessToken');

        $I->haveHttpHeader('Authorization', 'Bearer ' . $token);
        $I->sendGET('/api/user');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Illuminate\Http\Response::HTTP_OK);
        $response = json_decode($I->grabResponse(), true);
        $this->assertEquals($userName, $response['first_name']);
        $this->assertEquals($userLastName, $response['last_name']);
        $this->assertEquals($userEmail, $response['email']);
        $I->dontSeeResponseJsonMatchesJsonPath('password');
    }

    public function testLanguage(ApiTester $I)
    {
        $I->haveHttpHeader('Accept-Language', 'de');
        $I->sendPOST('/api/register');

        $deMessage = json_decode($I->grabResponse(), true)['message'];

        $this->assertEquals("Das first name field ist erforderlich. Das last name field ist erforderlich. Das email field ist erforderlich. Das password field ist erforderlich. ", $deMessage);

        $I->haveHttpHeader('Accept-Language', 'en');
        $I->sendPOST('/api/register');

        $enMessage = json_decode($I->grabResponse(), true)['message'];
        $this->assertEquals("The first name field is required. The last name field is required. The email field is required. The password field is required. ", $enMessage);

        $I->haveHttpHeader('Accept-Language', 'fr');
        $I->sendPOST('/api/register');

        //No Frech, should be still eng
        $enMessage = json_decode($I->grabResponse(), true)['message'];
        $this->assertEquals("The first name field is required. The last name field is required. The email field is required. The password field is required. ", $enMessage);
    }
}
