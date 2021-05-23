<?php

namespace Tests\Controller\Front;

use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends WebTestCase
{
    use ReloadDatabaseTrait;

    /**
     * testRouteUserFrontController.
     *
     * @dataProvider setRouteForUserFrontController
     *
     * Test la réponse des différentes chemin pour le controller UserController (front)
     *
     * @param string $method
     */
    public function testRouteUserFrontController(string $uri, int $response): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, $uri);
        $this->assertEquals($response, $client->getResponse()->getStatusCode());
    }

    /**
     * testRegistration
     * L'inscription d'un nouvelle utilisateur.
     */
    public function testRegistration(): void
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/inscription');

        $form = $crawler->selectButton('inscription')->form();
        $form['user_register[username]'] = 'johnDoe';
        $form['user_register[email]'] = 'johndoe@domaine.fr';
        $form['user_register[password]'] = 'Hum123';
        $client->submit($form);

        //Redirection vers la page de connexion
        $this->assertEquals(true, $client->getResponse()->isRedirect('/login'));
    }

    /**
     * setRouteForUserFrontController.
     */
    public function setRouteForUserFrontController(): array
    {
        return [
            ['/inscription',   Response::HTTP_OK]
        ];
    }
}
