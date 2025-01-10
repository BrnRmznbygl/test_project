<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110170246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A8957C46');
        $this->addSql('DROP INDEX IDX_8D93D649A8957C46 ON user');
        $this->addSql('ALTER TABLE user ADD experience_rating INT DEFAULT NULL, ADD collaboration_rating INT DEFAULT NULL, ADD communication_rating INT DEFAULT NULL, ADD timeliness_rating INT DEFAULT NULL, DROP rated_user_id, DROP rating_score, CHANGE rating_comment comment_rating LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD rated_user_id INT DEFAULT NULL, ADD rating_score INT DEFAULT NULL, DROP experience_rating, DROP collaboration_rating, DROP communication_rating, DROP timeliness_rating, CHANGE comment_rating rating_comment LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A8957C46 FOREIGN KEY (rated_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649A8957C46 ON user (rated_user_id)');
    }
}
