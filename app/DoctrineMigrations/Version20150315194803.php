<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Ghribi\ApiBundle\Entity\Letter;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150315194803 extends AbstractMigration implements ContainerAwareInterface
{
    /** @var ContainerInterface $container */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE letter_field_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE letter_field (id INT NOT NULL, label VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A6100D1D5E237E06 ON letter_field (name)');
        $this->addSql('CREATE TABLE letter_letter_field (letter_id INT NOT NULL, letterfield_id INT NOT NULL, PRIMARY KEY(letter_id, letterfield_id))');
        $this->addSql('CREATE INDEX IDX_C71059174525FF26 ON letter_letter_field (letter_id)');
        $this->addSql('CREATE INDEX IDX_C7105917C57669CA ON letter_letter_field (letterfield_id)');
        $this->addSql('ALTER TABLE letter_letter_field ADD CONSTRAINT FK_C71059174525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE letter_letter_field ADD CONSTRAINT FK_C7105917C57669CA FOREIGN KEY (letterfield_id) REFERENCES letter_field (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE letter ALTER name DROP DEFAULT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE letter_letter_field DROP CONSTRAINT FK_C7105917C57669CA');
        $this->addSql('DROP SEQUENCE letter_field_id_seq CASCADE');
        $this->addSql('DROP TABLE letter_field');
        $this->addSql('DROP TABLE letter_letter_field');
        $this->addSql('ALTER TABLE letter ALTER name SET DEFAULT \'\'');
    }

    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $letterFieldService =  $this->container->get('letter_field_updater.service');
        $letterFieldService->setEntityManager($em);

        $letters = $em->getRepository('GhribiApiBundle:Letter')->findAll();

        /** @var Letter $letter */
        foreach($letters as $letter) {
            $letterFieldService->updateLetterFields($letter);
        }
    }
}
