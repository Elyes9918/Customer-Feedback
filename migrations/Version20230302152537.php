<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302152537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedback ADD sujet VARCHAR(255) DEFAULT NULL, ADD status INT DEFAULT NULL, ADD realised INT DEFAULT NULL, ADD estimated_time INT DEFAULT NULL, ADD priority INT DEFAULT NULL, ADD rating INT DEFAULT NULL, ADD file LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE historique ADD description VARCHAR(255) DEFAULT NULL, ADD file LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD client VARCHAR(255) DEFAULT NULL, ADD status VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedback DROP sujet, DROP status, DROP realised, DROP estimated_time, DROP priority, DROP rating, DROP file');
        $this->addSql('ALTER TABLE historique DROP description, DROP file');
        $this->addSql('ALTER TABLE project DROP client, DROP status');
    }
}
