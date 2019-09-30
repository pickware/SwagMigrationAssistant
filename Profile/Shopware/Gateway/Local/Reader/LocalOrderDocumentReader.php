<?php declare(strict_types=1);

namespace SwagMigrationAssistant\Profile\Shopware\Gateway\Local\Reader;

use Doctrine\DBAL\Connection;
use SwagMigrationAssistant\Migration\DataSelection\DefaultEntities;
use SwagMigrationAssistant\Migration\MigrationContextInterface;
use SwagMigrationAssistant\Profile\Shopware\ShopwareProfileInterface;

class LocalOrderDocumentReader extends LocalAbstractReader implements LocalReaderInterface
{
    public function supports(MigrationContextInterface $migrationContext): bool
    {
        return $migrationContext->getProfile() instanceof ShopwareProfileInterface
            && $migrationContext->getDataSet()::getEntity() === DefaultEntities::ORDER_DOCUMENT;
    }

    public function read(MigrationContextInterface $migrationContext, array $params = []): array
    {
        $this->setConnection($migrationContext);
        $documents = $this->mapData($this->fetchDocuments($migrationContext), [], ['document']);

        $locale = $this->getDefaultShopLocale();

        foreach ($documents as &$document) {
            $document['_locale'] = str_replace('_', '-', $locale);
        }

        return $documents;
    }

    private function fetchDocuments(MigrationContextInterface $migrationContext): array
    {
        $ids = $this->fetchIdentifiers('s_order_documents', $migrationContext->getOffset(), $migrationContext->getLimit());

        $query = $this->connection->createQueryBuilder();

        $query->from('s_order_documents', 'document');
        $this->addTableSelection($query, 's_order_documents', 'document');

        $query->leftJoin('document', 's_order_documents_attributes', 'attributes', 'document.id = attributes.documentID');
        $this->addTableSelection($query, 's_order_documents_attributes', 'attributes');

        $query->leftJoin('document', 's_core_documents', 'document_documenttype', 'document.type = document_documenttype.id');
        $this->addTableSelection($query, 's_core_documents', 'document_documenttype');

        $query->setParameter('ids', $ids, Connection::PARAM_STR_ARRAY);

        return $query->execute()->fetchAll();
    }
}
