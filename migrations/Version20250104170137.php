<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104170137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developper (id INT AUTO_INCREMENT NOT NULL, user_developper_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, localisation VARCHAR(255) DEFAULT NULL, languages LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', min_salary DOUBLE PRECISION DEFAULT NULL, bio LONGTEXT DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_63D89B41E32A86C3 (user_developper_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE developper ADD CONSTRAINT FK_63D89B41E32A86C3 FOREIGN KEY (user_developper_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE entreprise ADD user_entreprise_id INT NOT NULL');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA604A2002BA FOREIGN KEY (user_entreprise_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D19FA604A2002BA ON entreprise (user_entreprise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developper DROP FOREIGN KEY FK_63D89B41E32A86C3');
        $this->addSql('DROP TABLE developper');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA604A2002BA');
        $this->addSql('DROP INDEX UNIQ_D19FA604A2002BA ON entreprise');
        $this->addSql('ALTER TABLE entreprise DROP user_entreprise_id');
    }
}
