<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// Ces tests vérifient le comportement du contrôleur et le rendu des horaires.
class FooterControllerTest extends WebTestCase
{
    public function testHorairesOuverture(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/'); // Remplacez par la route où le footer est chargé

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('footer', 'Le footer est présent');
        $this->assertSelectorTextContains('footer', 'Horaires d\'ouverture', 'Les horaires sont affichés');
    }
}
