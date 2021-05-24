<?php

namespace Tests\Controller\Back;

use App\Repository\UserRepository;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    
    /**
     * testAccessRouteForUserControllerWithNotUserConnected
     * Test l'accès aux routes du UserController ( Back ) si un utilisateur n'est pas connecté 
     * 
     * @dataProvider setRouteForUserControllerNotUserConnected
     *
     * @return void
     */
    public function testAccessRouteForUserControllerWithNotUserConnected(string $route, int $response): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, $route);
        $this->assertEquals($response, $client->getResponse()->getStatusCode());
    }
    
    /**
     * testAccessRouteForUserControllerWithUserConnected
     * Test l'accès aux routes du UserController ( Back ) si un utilisateur est connecté
     * 
     * @dataProvider setRouteForUserControllerUserConnected
     *
     * @return void
     */
    public function testAccessRouteForUserControllerWithUserConnected(string $route, int $response): void
    {
        $client = static::createClient();
        $this->login($client);

        $client->request(Request::METHOD_GET, '/admin/user/edit/1');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * testAccessEditProfilLoginNotOwn
     * si l'utilisateur est connecté et ne possède pas les informations du compte
     *
     * @return void
     */
    public function testAccessEditProfilLoginNotOwn(): void
    {
        $client = static::createClient();
        $this->login($client);

        $client->request(Request::METHOD_GET, '/admin/user/edit/2');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }
    
    /**
     * testEditProfil
     * Test si un utilisateur peut modifier ses données
     *
     * @return void
     */
    public function testEditProfil(): void
    {
        $client = static::createClient();
        $this->login($client);

        $crawler = $client->request(Request::METHOD_GET, '/admin/user/edit/1');
        $form = $crawler->selectButton('modifier')->form();
        $form['user_edit[email]'] = 'username@domaine.edit';
        $form['user_edit[newPassword]'] = 'Hum123';
        $client->submit($form);

        $this->assertEquals(true, $client->getResponse()->isRedirect('/admin/dashboard'));
    }

    /**
     * getLogin
     * Simule la connexion d'un utilisateur
     *
     * @param  KernelBrowser $client
     * @return void
     */
    private function login(KernelBrowser $client): void
    {
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('username');
        $client->loginUser($testUser);
    }
    
    /**
     * setRouteForUserControllerNotUserConnected
     * Données avec la route et la réponse attendu lorsqu'un utilisateur n'est pas connecté.
     *
     * @return void
     */
    public function setRouteForUserControllerNotUserConnected()
    {
        return [
            "Pour la modification du profil"
                => ['/admin/user/edit/1', Response::HTTP_FOUND],
            "Pour la suppression du profil"
                => ['/admin/user/delete/1', Response::HTTP_FOUND]
        ];
    }
    
    /**
     * testDeleteProfil
     * Suppression d'un profil
     *
     * @return void
     */
    public function testDeleteProfil(): void
    {
        $client = static::createClient();
        $this->login($client);

        $client->request(Request::METHOD_GET, '/admin/user/delete/1');
        $this->assertEquals(true, $client->getResponse()->isRedirect('/'));
    }

    /**
     * setRouteForUserControllerUserConnected
     * Données avec la route et la réponse attendu lorsqu'un utilisateur est connecté.
     *
     * @return void
     */
    public function setRouteForUserControllerUserConnected()
    {
        return [
            "Pour la modification du profil"    
                => ['/admin/user/edit/1', Response::HTTP_OK],
            "Pour la modification d'un autre profil"    
                => ['/admin/user/edit/1', Response::HTTP_FORBIDDEN],
            "Pour la suppression du profil"     
                => ['/admin/user/delete/1', Response::HTTP_FOUND],
            "Pour la suppression d'au autre profil"
                => ['/admin/user/delete/2', Response::HTTP_FORBIDDEN]
        ];
    }
}