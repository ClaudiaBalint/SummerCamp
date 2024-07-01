<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701042157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercises (id INT AUTO_INCREMENT NOT NULL, tipe_id INT NOT NULL, name VARCHAR(255) NOT NULL, video_link VARCHAR(2048) DEFAULT NULL, INDEX IDX_FA14991C69A8E08 (tipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercises_log (id INT AUTO_INCREMENT NOT NULL, workout_id INT NOT NULL, exercises_id INT NOT NULL, nr_reps INT NOT NULL, weight INT NOT NULL, time TIME NOT NULL, INDEX IDX_9F40D188A6CCCFC9 (workout_id), INDEX IDX_9F40D1881AFA70CA (exercises_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, gender SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout (id INT AUTO_INCREMENT NOT NULL, tipe_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_649FFB72C69A8E08 (tipe_id), INDEX IDX_649FFB72A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercises ADD CONSTRAINT FK_FA14991C69A8E08 FOREIGN KEY (tipe_id) REFERENCES tipe (id)');
        $this->addSql('ALTER TABLE exercises_log ADD CONSTRAINT FK_9F40D188A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id)');
        $this->addSql('ALTER TABLE exercises_log ADD CONSTRAINT FK_9F40D1881AFA70CA FOREIGN KEY (exercises_id) REFERENCES exercises (id)');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72C69A8E08 FOREIGN KEY (tipe_id) REFERENCES tipe (id)');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercises DROP FOREIGN KEY FK_FA14991C69A8E08');
        $this->addSql('ALTER TABLE exercises_log DROP FOREIGN KEY FK_9F40D188A6CCCFC9');
        $this->addSql('ALTER TABLE exercises_log DROP FOREIGN KEY FK_9F40D1881AFA70CA');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72C69A8E08');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72A76ED395');
        $this->addSql('DROP TABLE exercises');
        $this->addSql('DROP TABLE exercises_log');
        $this->addSql('DROP TABLE tipe');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE workout');
    }
}
