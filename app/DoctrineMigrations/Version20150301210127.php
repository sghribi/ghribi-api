<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150301210127 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE api_refresh_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE api_access_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE api_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE api_client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE api_auth_code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE api_refresh_token (id INT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6F2294195F37A13B ON api_refresh_token (token)');
        $this->addSql('CREATE INDEX IDX_6F22941919EB6921 ON api_refresh_token (client_id)');
        $this->addSql('CREATE INDEX IDX_6F229419A76ED395 ON api_refresh_token (user_id)');
        $this->addSql('CREATE TABLE api_access_token (id INT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BCC804C55F37A13B ON api_access_token (token)');
        $this->addSql('CREATE INDEX IDX_BCC804C519EB6921 ON api_access_token (client_id)');
        $this->addSql('CREATE INDEX IDX_BCC804C5A76ED395 ON api_access_token (user_id)');
        $this->addSql('CREATE TABLE api_user (id INT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, locked BOOLEAN NOT NULL, expired BOOLEAN NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, credentials_expired BOOLEAN NOT NULL, credentials_expire_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC64A0BA92FC23A8 ON api_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC64A0BAA0D96FBF ON api_user (email_canonical)');
        $this->addSql('COMMENT ON COLUMN api_user.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE api_client (id INT NOT NULL, random_id VARCHAR(255) NOT NULL, redirect_uris TEXT NOT NULL, secret VARCHAR(255) NOT NULL, allowed_grant_types TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN api_client.redirect_uris IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN api_client.allowed_grant_types IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE api_auth_code (id INT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, redirect_uri TEXT NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24E775575F37A13B ON api_auth_code (token)');
        $this->addSql('CREATE INDEX IDX_24E7755719EB6921 ON api_auth_code (client_id)');
        $this->addSql('CREATE INDEX IDX_24E77557A76ED395 ON api_auth_code (user_id)');
        $this->addSql('ALTER TABLE api_refresh_token ADD CONSTRAINT FK_6F22941919EB6921 FOREIGN KEY (client_id) REFERENCES api_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE api_refresh_token ADD CONSTRAINT FK_6F229419A76ED395 FOREIGN KEY (user_id) REFERENCES api_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE api_access_token ADD CONSTRAINT FK_BCC804C519EB6921 FOREIGN KEY (client_id) REFERENCES api_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE api_access_token ADD CONSTRAINT FK_BCC804C5A76ED395 FOREIGN KEY (user_id) REFERENCES api_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE api_auth_code ADD CONSTRAINT FK_24E7755719EB6921 FOREIGN KEY (client_id) REFERENCES api_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE api_auth_code ADD CONSTRAINT FK_24E77557A76ED395 FOREIGN KEY (user_id) REFERENCES api_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE api_refresh_token DROP CONSTRAINT FK_6F229419A76ED395');
        $this->addSql('ALTER TABLE api_access_token DROP CONSTRAINT FK_BCC804C5A76ED395');
        $this->addSql('ALTER TABLE api_auth_code DROP CONSTRAINT FK_24E77557A76ED395');
        $this->addSql('ALTER TABLE api_refresh_token DROP CONSTRAINT FK_6F22941919EB6921');
        $this->addSql('ALTER TABLE api_access_token DROP CONSTRAINT FK_BCC804C519EB6921');
        $this->addSql('ALTER TABLE api_auth_code DROP CONSTRAINT FK_24E7755719EB6921');
        $this->addSql('DROP SEQUENCE api_refresh_token_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE api_access_token_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE api_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE api_client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE api_auth_code_id_seq CASCADE');
        $this->addSql('DROP TABLE api_refresh_token');
        $this->addSql('DROP TABLE api_access_token');
        $this->addSql('DROP TABLE api_user');
        $this->addSql('DROP TABLE api_client');
        $this->addSql('DROP TABLE api_auth_code');
    }
}
