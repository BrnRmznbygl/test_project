<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110180837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developper_entreprise DROP FOREIGN KEY FK_B164FB50A4AEAFEA');
        $this->addSql('ALTER TABLE developper_entreprise DROP FOREIGN KEY FK_B164FB50DA42B93');
        $this->addSql('ALTER TABLE developper_post DROP FOREIGN KEY FK_C53757264B89032C');
        $this->addSql('ALTER TABLE developper_post DROP FOREIGN KEY FK_C5375726DA42B93');
        $this->addSql('ALTER TABLE developper_developper DROP FOREIGN KEY FK_DFA59A71A3726CC8');
        $this->addSql('ALTER TABLE developper_developper DROP FOREIGN KEY FK_DFA59A71BA973C47');
        $this->addSql('DROP TABLE developper_entreprise');
        $this->addSql('DROP TABLE developper_post');
        $this->addSql('DROP TABLE developper_developper');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developper_entreprise (developper_id INT NOT NULL, entreprise_id INT NOT NULL, INDEX IDX_B164FB50A4AEAFEA (entreprise_id), INDEX IDX_B164FB50DA42B93 (developper_id), PRIMARY KEY(developper_id, entreprise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE developper_post (developper_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_C53757264B89032C (post_id), INDEX IDX_C5375726DA42B93 (developper_id), PRIMARY KEY(developper_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE developper_developper (developper_source INT NOT NULL, developper_target INT NOT NULL, INDEX IDX_DFA59A71BA973C47 (developper_target), INDEX IDX_DFA59A71A3726CC8 (developper_source), PRIMARY KEY(developper_source, developper_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE developper_entreprise ADD CONSTRAINT FK_B164FB50A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_entreprise ADD CONSTRAINT FK_B164FB50DA42B93 FOREIGN KEY (developper_id) REFERENCES developper (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_post ADD CONSTRAINT FK_C53757264B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_post ADD CONSTRAINT FK_C5375726DA42B93 FOREIGN KEY (developper_id) REFERENCES developper (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_developper ADD CONSTRAINT FK_DFA59A71A3726CC8 FOREIGN KEY (developper_source) REFERENCES developper (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_developper ADD CONSTRAINT FK_DFA59A71BA973C47 FOREIGN KEY (developper_target) REFERENCES developper (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
