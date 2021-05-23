<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends WebTestCase
{
    /**
     * testRouteSecurityController.
     *
     * @dataProvider setRouteForSecurityController
     *
     * Test la réponse des différentes chemin pour le controller UserController (front)
     *
     * @param string $method
     */
    public function testRouteSecurityController(string $uri, int $response): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, $uri);
        $this->assertEquals($response, $client->getResponse()->getStatusCode());
    }

    /**
     * testLogin
     * 
     * @return void
     */
    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/login');

        $form = $crawler->selectButton('connexion')->form();
        $form['username'] = 'username';
        $form['password'] = '0000';
        $client->submit($form);

        $this->assertEquals(true, $client->getResponse()->isRedirect('/admin/dashboard'));
    }

    /**
     * setRouteForSecurityController.
     */
    public function setRouteForSecurityController(): array
    {
        return [
            ['/login',   Response::HTTP_OK]
        ];
    }
}