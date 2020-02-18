<?php

use Codeception\Util\Shared\Asserts;

class TestDemoCest
{
    use Asserts;

    public function testLoginUser(ApiTester $I)
    {

        $I->sendPOST('/api/login', [
            'email' => 'admin@stryber.com',
            'password' => 'Qweqwe'
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Illuminate\Http\Response::HTTP_OK);
        $I->seeResponseJsonMatchesJsonPath('$.accessToken');
    }

    public function testUserInfoRequest(ApiTester $I)
    {

        $user = \App\User::query()->where('email', 'admin@stryber.com')->first();

        $I->sendPOST('/api/login', [
            'email' => 'admin@stryber.com',
            'password' => 'Qweqwe'
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Illuminate\Http\Response::HTTP_OK);

        $token = \Illuminate\Support\Arr::get(json_decode($I->grabResponse(), true), 'accessToken');

        $I->haveHttpHeader('Authorization', 'Bearer ' . $token);
        $I->sendGET('/api/user');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Illuminate\Http\Response::HTTP_OK);
        $response = json_decode($I->grabResponse(), true);
        $this->assertEquals($user->first_name, $response['first_name']);
        $this->assertEquals($user->last_name, $response['last_name']);
        $this->assertEquals($user->email, $response['email']);
        $I->dontSeeResponseJsonMatchesJsonPath('password');
    }
}
