<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110180106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developper ADD total_ratings DOUBLE PRECISION NOT NULL, ADD number_of_ratings INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP comment_rating, DROP rating_date, DROP experience_rating, DROP collaboration_rating, DROP communication_rating, DROP timeliness_rating');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD comment_rating LONGTEXT DEFAULT NULL, ADD rating_date DATETIME DEFAULT NULL, ADD experience_rating INT DEFAULT NULL, ADD collaboration_rating INT DEFAULT NULL, ADD communication_rating INT DEFAULT NULL, ADD timeliness_rating INT DEFAULT NULL');
        $this->addSql('ALTER TABLE developper DROP total_ratings, DROP number_of_ratings');
    }
}
