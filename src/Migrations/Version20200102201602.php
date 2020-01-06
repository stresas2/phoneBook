<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200102201602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact_req (id INT AUTO_INCREMENT NOT NULL, fk_sending_user_id INT NOT NULL, fk_receiving_user_id INT NOT NULL, name VARCHAR(255) NOT NULL, number INT NOT NULL, INDEX IDX_6A86DA5CA4DF1A48 (fk_sending_user_id), INDEX IDX_6A86DA5C87D5D68E (fk_receiving_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_req ADD CONSTRAINT FK_6A86DA5CA4DF1A48 FOREIGN KEY (fk_sending_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contact_req ADD CONSTRAINT FK_6A86DA5C87D5D68E FOREIGN KEY (fk_receiving_user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE contacts_request');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contacts_request (id INT AUTO_INCREMENT NOT NULL, fk_sending_user_id INT NOT NULL, fk_receiving_user_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, number INT NOT NULL, UNIQUE INDEX UNIQ_B13F83C2A4DF1A48 (fk_sending_user_id), UNIQUE INDEX UNIQ_B13F83C287D5D68E (fk_receiving_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contacts_request ADD CONSTRAINT FK_B13F83C287D5D68E FOREIGN KEY (fk_receiving_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contacts_request ADD CONSTRAINT FK_B13F83C2A4DF1A48 FOREIGN KEY (fk_sending_user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE contact_req');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
