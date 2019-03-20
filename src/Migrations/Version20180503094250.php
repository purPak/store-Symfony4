<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180503094250 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE identity_user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_user ADD identity_id INT NOT NULL');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E9FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9FF3ED4A8 ON app_user (identity_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_user DROP FOREIGN KEY FK_88BDF3E9FF3ED4A8');
        $this->addSql('DROP TABLE identity_user');
        $this->addSql('DROP INDEX UNIQ_88BDF3E9FF3ED4A8 ON app_user');
        $this->addSql('ALTER TABLE app_user DROP identity_id');
    }
}
