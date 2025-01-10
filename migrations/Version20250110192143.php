<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110192143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developper_user DROP FOREIGN KEY FK_122EEDE2A76ED395');
        $this->addSql('ALTER TABLE developper_user DROP FOREIGN KEY FK_122EEDE2DA42B93');
        $this->addSql('DROP TABLE developper_user');
        $this->addSql('ALTER TABLE developper ADD ratings JSON DEFAULT NULL, DROP total_ratings, DROP number_of_ratings');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developper_user (developper_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_122EEDE2DA42B93 (developper_id), INDEX IDX_122EEDE2A76ED395 (user_id), PRIMARY KEY(developper_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE developper_user ADD CONSTRAINT FK_122EEDE2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_user ADD CONSTRAINT FK_122EEDE2DA42B93 FOREIGN KEY (developper_id) REFERENCES developper (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper ADD total_ratings DOUBLE PRECISION NOT NULL, ADD number_of_ratings INT NOT NULL, DROP ratings');
    }
}
