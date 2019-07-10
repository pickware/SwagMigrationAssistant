<?php declare(strict_types=1);

namespace SwagMigrationAssistant\Profile\Shopware55\Gateway\Api\Reader;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Shopware\Core\Framework\Context;
use SwagMigrationAssistant\Exception\GatewayReadException;
use SwagMigrationAssistant\Migration\DataSelection\DataSet\CountingQueryStruct;
use SwagMigrationAssistant\Migration\DataSelection\DataSet\DataSet;
use SwagMigrationAssistant\Migration\DataSelection\DataSet\DataSetRegistryInterface;
use SwagMigrationAssistant\Migration\Logging\LoggingService;
use SwagMigrationAssistant\Migration\Logging\LogType;
use SwagMigrationAssistant\Migration\MigrationContextInterface;
use SwagMigrationAssistant\Migration\TotalStruct;
use SwagMigrationAssistant\Profile\Shopware55\Gateway\Connection\ConnectionFactoryInterface;
use SwagMigrationAssistant\Profile\Shopware55\Gateway\TableCountReaderInterface;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Shopware55ApiTableCountReader implements TableCountReaderInterface
{
    /**
     * @var ConnectionFactoryInterface
     */
    private $connectionFactory;

    /**
     * @var DataSetRegistryInterface
     */
    private $dataSetRegistry;

    /**
     * @var LoggingService
     */
    private $loggingService;

    public function __construct(
        ConnectionFactoryInterface $connectionFactory,
        DataSetRegistryInterface $dataSetRegistry,
        LoggingService $loggingService
    ) {
        $this->connectionFactory = $connectionFactory;
        $this->dataSetRegistry = $dataSetRegistry;
        $this->loggingService = $loggingService;
    }

    public function readTotals(MigrationContextInterface $migrationContext, Context $context): array
    {
        $dataSets = $this->dataSetRegistry->getDataSets($migrationContext->getConnection()->getProfileName());
        $countingInformation = $this->getCountingInformation($dataSets);

        $client = $this->connectionFactory->createApiClient($migrationContext);
        /** @var GuzzleResponse $result */
        $result = $client->get(
            'SwagMigrationTotals',
            [
                'query' => [
                    'countInfos' => $countingInformation,
                ],
            ]
        );

        if ($result->getStatusCode() !== SymfonyResponse::HTTP_OK) {
            throw new GatewayReadException('Shopware 5.5 Api table count.');
        }

        $arrayResult = json_decode($result->getBody()->getContents(), true);

        if (!isset($arrayResult['data'])) {
            return [];
        }

        if (count($arrayResult['data']['exceptions']) > 0) {
            $this->logExceptions($arrayResult['data']['exceptions'], $migrationContext, $context);
        }

        return $this->prepareTotals($arrayResult['data']['totals']);
    }

    /**
     * @param DataSet[] $dataSets
     */
    private function getCountingInformation(array $dataSets): array
    {
        $countingInformation = [];

        foreach ($dataSets as $dataSet) {
            if ($dataSet->getCountingInformation() !== null) {
                $info = $dataSet->getCountingInformation();
                $queryData = [
                    'entity' => $dataSet::getEntity(),
                    'queryRules' => [],
                ];

                $queries = $info->getQueries();
                /** @var CountingQueryStruct $queryStruct */
                foreach ($queries as $queryStruct) {
                    $queryData['queryRules'][] = [
                        'table' => $queryStruct->getTableName(),
                        'condition' => $queryStruct->getCondition(),
                    ];
                }
                $countingInformation[] = $queryData;
            }
        }

        return $countingInformation;
    }

    /**
     * @return TotalStruct[]
     */
    private function prepareTotals(array $result): array
    {
        $totals = [];
        foreach ($result as $key => $tableResult) {
            $totals[$key] = new TotalStruct($key, $tableResult);
        }

        return $totals;
    }

    private function logExceptions(array $exceptionArray, MigrationContextInterface $migrationContext, Context $context): void
    {
        foreach ($exceptionArray as $exception) {
            $this->loggingService->addWarning(
                $migrationContext->getRunUuid(),
                LogType::COULD_NOT_READ_ENTITY_COUNT,
                'Could not read entity count',
                sprintf(
                    'Total count for entity %s could not be read. Make the the table %s exists in your source system and the optional condition "%s" is valid.',
                    $exception['entity'],
                    $exception['table'],
                    $exception['condition'] ?? ''
                ),
                [
                    'exceptionCode' => $exception['code'],
                    'exceptionMessage' => $exception['message'],
                    'entity' => $exception['entity'],
                    'table' => $exception['table'],
                    'condition' => $exception['condition'],
                ]
            );
        }

        $this->loggingService->saveLogging($context);
    }
}
