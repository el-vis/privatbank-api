<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class BalanceRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class BalanceRequestTest extends TestCase
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->client = new Client();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        $this->client = null;
    }

    public function testBalance()
    {
        $merchantId = getenv('merchantId');
        $merchantSecret = getenv('merchantSecret');
        $cardNumber = getenv('cardNumber');
        if (empty($cardNumber) || empty($merchantId) || empty($merchantSecret)) {
            $this->markTestSkipped('Merchant data not specified');
        }

        $merchant = new Merchant($merchantId, $merchantSecret);
        $this->client->setMerchant($merchant);
        $data = $this->client->balance([
            'cardNumber' => $cardNumber
        ]);
        $this->assertTrue(isset($data['card']));
        $card = $data['card'];
        $this->assertArrayHasKey('account', $card);
        $this->assertArrayHasKey('card_number', $card);
        $this->assertArrayHasKey('acc_name', $card);
        $this->assertArrayHasKey('currency', $card);
    }
}
