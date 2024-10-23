<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20241023090554 extends AbstractMigration
{
    public const TABLE_NAME = 'product_images';
    public const FK_NAME_PRODUCT = 'fk_product_images_product_id';

    public function getDescription(): string
    {
        return sprintf('Create %s table', self::TABLE_NAME);
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', Types::BIGINT, ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('src', Types::STRING);
        $table->addColumn('product_id', Types::BIGINT, ['notnull' => true, 'unsigned' => true]);
        $table->addColumn('created_at', Types::DATETIME_MUTABLE);
        $table->addColumn('updated_at', Types::DATETIME_MUTABLE);

        $table->addForeignKeyConstraint(
            Version20241023090552::TABLE_NAME,
            ['product_id'],
            ['id'],
            [],
            self::FK_NAME_PRODUCT
        );

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable(self::TABLE_NAME);
        $table->removeForeignKey(self::FK_NAME_PRODUCT);

        $schema->dropTable(self::TABLE_NAME);
    }
}
