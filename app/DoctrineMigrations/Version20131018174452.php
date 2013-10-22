<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131018174452 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE classement (id INT AUTO_INCREMENT NOT NULL, id_equipe INT NOT NULL, id_epreuve INT NOT NULL, position INT NOT NULL, points INT NOT NULL, INDEX IDX_55EE9D6D27E0FF8 (id_equipe), INDEX IDX_55EE9D6D8304D0F (id_epreuve), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE epreuve (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D27E0FF8 FOREIGN KEY (id_equipe) REFERENCES equipe (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D8304D0F FOREIGN KEY (id_epreuve) REFERENCES epreuve (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6D8304D0F");
        $this->addSql("ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6D27E0FF8");
        $this->addSql("DROP TABLE classement");
        $this->addSql("DROP TABLE epreuve");
        $this->addSql("DROP TABLE equipe");
    }
}
