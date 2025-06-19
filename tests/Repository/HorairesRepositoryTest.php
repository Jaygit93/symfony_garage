<?php

namespace App\Tests\Repository;

use App\Entity\Horaires;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

// Ces tests utilisent la base de données de test pour vérifier que le repository fonctionne correctement.
class HorairesRepositoryTest extends KernelTestCase
{
    public function testFindAll(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $entityManager = $container->get('doctrine')->getManager();

        // Ajouter un horaire de test
        $horaire = new Horaires();
        $horaire->setJour('Lundi')
                ->setHeureOuverture(new \DateTime('08:00'))
                ->setHeureFermeture(new \DateTime('18:00'));

        $entityManager->persist($horaire);
        $entityManager->flush();

        // Tester le repository
        $repository = $container->get('doctrine')->getRepository(Horaires::class);
        $horaires = $repository->findAll();

        $this->assertCount(1, $horaires);
        $this->assertEquals('Lundi', $horaires[0]->getJour());
    }
}
