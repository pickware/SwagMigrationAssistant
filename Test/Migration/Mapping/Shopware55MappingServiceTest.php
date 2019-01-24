<?php declare(strict_types=1);

namespace SwagMigrationNext\Test\Migration\Mapping;

use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\RepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Test\TestCaseBase\IntegrationTestBehaviour;
use SwagMigrationNext\Profile\Shopware55\Mapping\Shopware55MappingService;
use SwagMigrationNext\Test\Migration\Services\MigrationProfileUuidService;

class Shopware55MappingServiceTest extends TestCase
{
    use IntegrationTestBehaviour;

    /**
     * @var Shopware55MappingService
     */
    private $shopware55MappingService;

    /**
     * @var RepositoryInterface
     */
    private $localeRepo;

    /**
     * @var RepositoryInterface
     */
    private $orderStateRepo;

    /**
     * @var RepositoryInterface
     */
    private $transactionStateRepo;

    /**
     * @var MigrationProfileUuidService
     */
    private $profileUuidService;

    /**
     * @var EntityRepositoryInterface
     */
    private $transactionStateTranslationRepo;

    protected function setUp()
    {
        $this->localeRepo = $this->getContainer()->get('locale.repository');
        $this->orderStateRepo = $this->getContainer()->get('order_state.repository');
        $this->transactionStateRepo = $this->getContainer()->get('order_transaction_state.repository');
        $this->transactionStateTranslationRepo = $this->getContainer()->get('order_transaction_state_translation.repository');
        $this->profileUuidService = new MigrationProfileUuidService($this->getContainer()->get('swag_migration_profile.repository'));

        $this->shopware55MappingService = new Shopware55MappingService(
            $this->getContainer()->get('swag_migration_mapping.repository'),
            $this->localeRepo,
            $this->getContainer()->get('language.repository'),
            $this->getContainer()->get('country.repository'),
            $this->getContainer()->get('payment_method.repository'),
            $this->orderStateRepo,
            $this->transactionStateRepo,
            $this->getContainer()->get('currency.repository')
        );
    }

    public function testGetOrderStateUuid(): void
    {
        $context = Context::createDefaultContext();

        $response = $this->shopware55MappingService->getOrderStateUuid(-1, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getOrderStateUuid(1, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getOrderStateUuid(2, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getOrderStateUuid(3, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getOrderStateUuid(4, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getOrderStateUuid(5, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getOrderStateUuid(6, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getOrderStateUuid(7, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getOrderStateUuid(8, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getOrderStateUuid(10, $context);
        self::assertNull($response);

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('position', 8));
        $ids = $this->orderStateRepo->searchIds(
            $criteria,
            $context
        );
        $ids = $ids->getIds();

        $this->orderStateRepo->delete(
            [
                [
                    'id' => $ids[0],
                ],
            ],
            $context
        );
        $response = $this->shopware55MappingService->getOrderStateUuid(6, $context);
        self::assertNull($response);
    }

    public function testTransactionStateUuid(): void
    {
        $context = Context::createDefaultContext();

        $response = $this->shopware55MappingService->getTransactionStateUuid(9, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(10, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(11, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(12, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(13, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(14, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(15, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(16, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(17, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(18, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(19, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(20, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(21, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(30, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(31, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(32, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(33, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(34, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(35, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(0, $context);
        self::assertNotNull($response);

        $response = $this->shopware55MappingService->getTransactionStateUuid(666, $context);
        self::assertNull($response);
    }
}
