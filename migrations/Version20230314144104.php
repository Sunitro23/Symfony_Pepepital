<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314144104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assistant DROP FOREIGN KEY FK_C2997CD1A76ED396');
        $this->addSql('DROP INDEX FK_C2997CD1A76ED396 ON assistant');
        $this->addSql('ALTER TABLE assistant DROP medecin_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assistant ADD medecin_id INT NOT NULL');
        $this->addSql('ALTER TABLE assistant ADD CONSTRAINT FK_C2997CD1A76ED396 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('CREATE INDEX FK_C2997CD1A76ED396 ON assistant (medecin_id)');
    }
}
