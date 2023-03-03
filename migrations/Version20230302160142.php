<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302160142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedback CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE historique CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE project CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE modified_at modified_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedback CHANGE modified_at modified_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE historique CHANGE modified_at modified_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE project CHANGE modified_at modified_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE modified_at modified_at DATE DEFAULT NULL');
    }
}
