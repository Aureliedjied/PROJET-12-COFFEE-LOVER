<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214165001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gif ADD picture VARCHAR(255) DEFAULT NULL, ADD soundstrack VARCHAR(255) DEFAULT NULL, DROP picture_file, DROP audio_file, CHANGE title title VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gif ADD picture_file VARCHAR(255) DEFAULT NULL, ADD audio_file VARCHAR(255) DEFAULT NULL, DROP picture, DROP soundstrack, CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quiz DROP picture');
    }
}
