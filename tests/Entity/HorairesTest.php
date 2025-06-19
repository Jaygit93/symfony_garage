<?php

namespace App\Tests\Entity;

use App\Entity\Horaires;
use PHPUnit\Framework\TestCase;

// Ces tests vérifient le bon fonctionnement des getters et setters.
class HorairesTest extends TestCase
{
    public function testHorairesEntity(): void
    {
        $horaires = new Horaires();

        // Test du jour
        $horaires->setJour('Lundi');
        $this->assertEquals('Lundi', $horaires->getJour());

        // Test des heures
        $heureOuverture = new \DateTime('08:00');
        $heureFermeture = new \DateTime('18:00');
        $horaires->setHeureOuverture($heureOuverture);
        $horaires->setHeureFermeture($heureFermeture);

        $this->assertEquals($heureOuverture, $horaires->getHeureOuverture());
        $this->assertEquals($heureFermeture, $horaires->getHeureFermeture());
    }
}
