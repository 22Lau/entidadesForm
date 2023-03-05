<?php

namespace App\Test\Controller;

use App\Entity\Cliente;
use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClienteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ClienteRepository $repository;
    private string $path = '/cliente/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Cliente::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cliente index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'cliente[nombre]' => 'Testing',
            'cliente[apellidos]' => 'Testing',
            'cliente[email]' => 'Testing',
            'cliente[password]' => 'Testing',
            'cliente[preferencia]' => 'Testing',
        ]);

        self::assertResponseRedirects('/cliente/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cliente();
        $fixture->setNombre('My Title');
        $fixture->setApellidos('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPassword('My Title');
        $fixture->setPreferencia('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cliente');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cliente();
        $fixture->setNombre('My Title');
        $fixture->setApellidos('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPassword('My Title');
        $fixture->setPreferencia('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'cliente[nombre]' => 'Something New',
            'cliente[apellidos]' => 'Something New',
            'cliente[email]' => 'Something New',
            'cliente[password]' => 'Something New',
            'cliente[preferencia]' => 'Something New',
        ]);

        self::assertResponseRedirects('/cliente/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getApellidos());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getPreferencia());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Cliente();
        $fixture->setNombre('My Title');
        $fixture->setApellidos('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPassword('My Title');
        $fixture->setPreferencia('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/cliente/');
    }
}
