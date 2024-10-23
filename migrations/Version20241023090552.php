<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20241023090552 extends AbstractMigration
{
    public const TABLE_NAME = 'products';

    public function getDescription(): string
    {
        return sprintf('Create %s table', self::TABLE_NAME);
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', Types::BIGINT, ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('name', Types::STRING);
        $table->addColumn('link', Types::STRING);
        $table->addColumn('amount', Types::FLOAT);
        $table->addColumn('currency', Types::STRING);
        $table->addColumn('created_at', Types::DATETIME_MUTABLE);
        $table->addColumn('updated_at', Types::DATETIME_MUTABLE);

        $table->setPrimaryKey(['id']);

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE_NAME);
    }
}
