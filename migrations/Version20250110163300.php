<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110163300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD rated_user_id INT DEFAULT NULL, ADD rating_score INT DEFAULT NULL, ADD rating_comment LONGTEXT DEFAULT NULL, ADD rating_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A8957C46 FOREIGN KEY (rated_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A8957C46 ON user (rated_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A8957C46');
        $this->addSql('DROP INDEX IDX_8D93D649A8957C46 ON user');
        $this->addSql('ALTER TABLE user DROP rated_user_id, DROP rating_score, DROP rating_comment, DROP rating_date');
    }
}
