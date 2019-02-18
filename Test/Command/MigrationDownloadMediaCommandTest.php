<?php declare(strict_types=1);

namespace SwagMigrationNext\Test\Command;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Media\File\FileSaver;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Test\TestCaseBase\IntegrationTestBehaviour;
use SwagMigrationNext\Command\MigrationDownloadMediaCommand;
use SwagMigrationNext\Command\MigrationFetchDataCommand;
use SwagMigrationNext\Command\MigrationWriteDataCommand;
use SwagMigrationNext\Migration\Logging\LoggingService;
use SwagMigrationNext\Migration\Media\CliMediaDownloadService;
use SwagMigrationNext\Migration\Media\MediaFileService;
use SwagMigrationNext\Migration\Service\MigrationDataFetcherInterface;
use SwagMigrationNext\Migration\Service\MigrationDataWriter;
use SwagMigrationNext\Migration\Service\MigrationDataWriterInterface;
use SwagMigrationNext\Migration\Writer\MediaWriter;
use SwagMigrationNext\Migration\Writer\WriterRegistry;
use SwagMigrationNext\Profile\Shopware55\Mapping\Shopware55MappingService;
use SwagMigrationNext\Test\MigrationServicesTrait;
use SwagMigrationNext\Test\Mock\Migration\Media\DummyCliMediaDownloadService;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MigrationDownloadMediaCommandTest extends TestCase
{
    use MigrationServicesTrait,
        IntegrationTestBehaviour;

    /**
     * @var EntityRepositoryInterface
     */
    private $loggingRepo;

    /**
     * @var EntityRepositoryInterface
     */
    private $productRepo;

    /**
     * @var EntityRepositoryInterface
     */
    private $migrationProfileRepo;

    /**
     * @var EntityRepositoryInterface
     */
    private $migrationDataRepo;

    /**
     * @var EntityRepositoryInterface
     */
    private $migrationRunRepo;

    /**
     * @var EntityRepositoryInterface
     */
    private $mediaRepo;

    /**
     * @var EntityRepositoryInterface
     */
    private $mediaFileRepo;

    /**
     * @var MigrationDataFetcherInterface
     */
    private $migrationDataFetcher;

    /**
     * @var MigrationDataWriterInterface
     */
    private $migrationWriteService;

    /**
     * @var FileSaver
     */
    private $fileSaver;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var CliMediaDownloadService
     */
    private $cliMediaDownloadService;

    /**
     * @var Application
     */
    private $application;

    protected function setUp(): void
    {
        $this->fileSaver = $this->getContainer()->get(FileSaver::class);
        $this->eventDispatcher = new EventDispatcher();

        $this->loggingRepo = $this->getContainer()->get('swag_migration_logging.repository');
        $this->productRepo = $this->getContainer()->get('product.repository');
        $this->mediaRepo = $this->getContainer()->get('media.repository');
        $this->mediaFileRepo = $this->getContainer()->get('swag_migration_media_file.repository');
        $this->migrationProfileRepo = $this->getContainer()->get('swag_migration_profile.repository');
        $this->migrationDataRepo = $this->getContainer()->get('swag_migration_data.repository');
        $this->migrationRunRepo = $this->getContainer()->get('swag_migration_run.repository');

        $this->migrationDataFetcher = $this->getMigrationDataFetcher(
            $this->migrationDataRepo,
            $this->getContainer()->get(Shopware55MappingService::class),
            $this->getContainer()->get(MediaFileService::class),
            $this->loggingRepo
        );

        $this->migrationWriteService = new MigrationDataWriter(
            $this->migrationDataRepo,
            new WriterRegistry(
                [
                    new MediaWriter($this->mediaRepo),
                ]
            ),
            $this->getContainer()->get(MediaFileService::class),
            $this->getContainer()->get(LoggingService::class)
        );
        $this->eventDispatcher = new EventDispatcher();

        $this->cliMediaDownloadService = new DummyCliMediaDownloadService(
            $this->mediaFileRepo,
            $this->fileSaver,
            $this->eventDispatcher,
            new ConsoleLogger(new ConsoleOutput())
        );
    }

    public function executeFetchCommand(array $options): string
    {
        return $this->executeCommand($options, 'migration:fetch:data');
    }

    public function executeWriteCommand(array $options): string
    {
        return $this->executeCommand($options, 'migration:write:data');
    }

    public function executeDownloadCommand(array $options): string
    {
        return $this->executeCommand($options, 'migration:media:download');
    }

    public function executeCommand(array $options, string $commandName): string
    {
        $command = $this->application->find($commandName);
        $commandTester = new CommandTester($command);
        $commandTester->execute($options);

        return $commandTester->getDisplay();
    }

    public function testDownloadData(): void
    {
        $this->markTestSkipped('Reason: New Run-Connection-Profile-Association');
        $this->createCommands();

        $output = $this->executeFetchCommand([
            '--profile' => 'shopware55',
            '--gateway' => 'local',
            '--entity' => 'media',
        ]);

        preg_match('/Run created: ([a-z,0-9]*)/', $output, $matches);
        $runId = $matches[1];

        $output = $this->executeWriteCommand([
            '--run-id' => $runId,
            '--entity' => 'media',
        ]);

        $this->assertStringContainsString('Written: 23', $output);
        $this->assertStringContainsString('Skipped: 0', $output);

        $output = $this->executeDownloadCommand([
            '--run-id' => $runId,
        ]);

        self::assertStringContainsString('Downloading done.', $output);
    }

    public function testDownloadDataWithoutRunId(): void
    {
        $this->markTestSkipped('Reason: New Run-Connection-Profile-Association');
        $kernel = $this->getKernel();
        $application = new Application($kernel);

        $application->add(new MigrationDownloadMediaCommand(
            $this->cliMediaDownloadService,
            $this->migrationRunRepo,
            $this->mediaFileRepo
        ));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No run-id provided');

        $command = $application->find('migration:media:download');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
        ]);
    }

    private function createCommands(): void
    {
        $this->markTestSkipped('Reason: New Run-Connection-Profile-Association');
        $kernel = $this->getKernel();
        $this->application = new Application($kernel);
        $this->application->add(new MigrationFetchDataCommand(
            $this->migrationDataFetcher,
            $this->migrationRunRepo,
            $this->migrationProfileRepo,
            $this->migrationDataRepo,
            'migration:fetch:data'
        ));
        $this->application->add(new MigrationWriteDataCommand(
            $this->migrationWriteService,
            $this->migrationRunRepo,
            $this->migrationDataRepo,
            $this->mediaFileRepo,
            'migration:write:data'
        ));

        $downloadCommand = new MigrationDownloadMediaCommand(
            $this->cliMediaDownloadService,
            $this->migrationRunRepo,
            $this->mediaFileRepo
        );

        $events = MigrationDownloadMediaCommand::getSubscribedEvents();
        foreach ($events as $event => $method) {
            $this->eventDispatcher->addListener($event, [$downloadCommand, $method]);
        }

        $this->application->add($downloadCommand);
    }
}