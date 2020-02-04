<?php

namespace Tests\_support;

use Tests\_support\Helper\Generator;

trait DefaultDataProducer
{
    /**
     * @var Generator
     */
    private $generator;

    private function produceUserData(\ApiTester $I)
    {
        $this->deliveryHub = $this->generator->getRandomDeliveryHub();

        $this->zipCode = $this->generator->getRandomZipCode([
            'delivery_hub_id' => $this->deliveryHub->id,
        ]);

        $this->client = $this->generator->getRandomOauthClient();
        $this->user = $this->generator->getRandomUser(['zip_code_id' => $this->zipCode->id]);

        $this->generator->getRandomUserHub([
            'user_id' => $this->user->id,
            'hub_id' => $this->deliveryHub->id,
        ]);

        $this->generator->getRandomUserAddress([
            'user_id' => $this->user->id,
            'zip_id' => $this->zipCode->id,
            'default' => true,
        ]);

        $this->token = (new \Tests\_support\Helper\Authorizer())->__getToken($I, $this->user, $this->client);
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->token);
        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
    }

    private function produceSingleProductData()
    {
        $supplier = $this->generator->getRandomSupplier();

        $this->category = $this->generator->getRandomCategory([
            'sorting' => 1
        ], [
            ['name' => md5(time() . rand(1, 100)), 'language_code' => 'de'],
            ['name' => md5(time() . rand(1, 100)), 'language_code' => 'en'],
        ]);

        $this->product = $this->generator->getRandomProduct([
            'category_id' => $this->category->id,
            'supplier_id' => $supplier->id,
        ], [
            ['language_code' => 'de', 'name' => md5(time() . rand(1, 100)), 'description' => md5(time().rand(1, 100))],
            ['language_code' => 'en', 'name' => md5(time() . rand(1, 100)), 'description' => md5(time().rand(1, 100))],
        ]);

        $this->hubItem = $this->generator->getRandomHubProduct([
            'hub_id' => $this->deliveryHub->id,
            'product_id' => $this->product->id,
        ]);
    }
}
