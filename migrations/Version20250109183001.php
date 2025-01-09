<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109183001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developper (id INT AUTO_INCREMENT NOT NULL, user_developper_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, localisation VARCHAR(255) DEFAULT NULL, views INT NOT NULL, created_at DATETIME NOT NULL, languages LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', experience_level INT NOT NULL, min_salary DOUBLE PRECISION DEFAULT NULL, bio LONGTEXT DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_63D89B41E32A86C3 (user_developper_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developper_entreprise (developper_id INT NOT NULL, entreprise_id INT NOT NULL, INDEX IDX_B164FB50DA42B93 (developper_id), INDEX IDX_B164FB50A4AEAFEA (entreprise_id), PRIMARY KEY(developper_id, entreprise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developper_post (developper_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_C5375726DA42B93 (developper_id), INDEX IDX_C53757264B89032C (post_id), PRIMARY KEY(developper_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developper_developper (developper_source INT NOT NULL, developper_target INT NOT NULL, INDEX IDX_DFA59A71A3726CC8 (developper_source), INDEX IDX_DFA59A71BA973C47 (developper_target), PRIMARY KEY(developper_source, developper_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, user_entreprise_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, localisation VARCHAR(255) DEFAULT NULL, bio LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_D19FA604A2002BA (user_entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, title VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, technologie VARCHAR(255) DEFAULT NULL, experience_level INT NOT NULL, salary DOUBLE PRECISION DEFAULT NULL, detail LONGTEXT NOT NULL, views INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5A8A6C8DA4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_public TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE developper ADD CONSTRAINT FK_63D89B41E32A86C3 FOREIGN KEY (user_developper_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE developper_entreprise ADD CONSTRAINT FK_B164FB50DA42B93 FOREIGN KEY (developper_id) REFERENCES developper (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_entreprise ADD CONSTRAINT FK_B164FB50A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_post ADD CONSTRAINT FK_C5375726DA42B93 FOREIGN KEY (developper_id) REFERENCES developper (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_post ADD CONSTRAINT FK_C53757264B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_developper ADD CONSTRAINT FK_DFA59A71A3726CC8 FOREIGN KEY (developper_source) REFERENCES developper (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developper_developper ADD CONSTRAINT FK_DFA59A71BA973C47 FOREIGN KEY (developper_target) REFERENCES developper (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA604A2002BA FOREIGN KEY (user_entreprise_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developper DROP FOREIGN KEY FK_63D89B41E32A86C3');
        $this->addSql('ALTER TABLE developper_entreprise DROP FOREIGN KEY FK_B164FB50DA42B93');
        $this->addSql('ALTER TABLE developper_entreprise DROP FOREIGN KEY FK_B164FB50A4AEAFEA');
        $this->addSql('ALTER TABLE developper_post DROP FOREIGN KEY FK_C5375726DA42B93');
        $this->addSql('ALTER TABLE developper_post DROP FOREIGN KEY FK_C53757264B89032C');
        $this->addSql('ALTER TABLE developper_developper DROP FOREIGN KEY FK_DFA59A71A3726CC8');
        $this->addSql('ALTER TABLE developper_developper DROP FOREIGN KEY FK_DFA59A71BA973C47');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA604A2002BA');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA4AEAFEA');
        $this->addSql('DROP TABLE developper');
        $this->addSql('DROP TABLE developper_entreprise');
        $this->addSql('DROP TABLE developper_post');
        $this->addSql('DROP TABLE developper_developper');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE user');
    }
}
