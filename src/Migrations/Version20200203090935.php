<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200203090935 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FC4663E4 ON image (page_id)');
        $this->addSql('ALTER TABLE content ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_FEC530A9C4663E4 ON content (page_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9C4663E4');
        $this->addSql('DROP INDEX IDX_FEC530A9C4663E4 ON content');
        $this->addSql('ALTER TABLE content DROP page_id');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC4663E4');
        $this->addSql('DROP INDEX IDX_C53D045FC4663E4 ON image');
        $this->addSql('ALTER TABLE image DROP page_id');
    }
}
