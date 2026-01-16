<?php

namespace App\Tests\Controller;

use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LocationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $locationRepository;
    private string $path = '/location/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->locationRepository = $this->manager->getRepository(Location::class);

        foreach ($this->locationRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Location index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'location[date_debut]' => 'Testing',
            'location[date_fin]' => 'Testing',
            'location[id_film]' => 'Testing',
            'location[id_user]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->locationRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Location();
        $fixture->setDate_debut('My Title');
        $fixture->setDate_fin('My Title');
        $fixture->setId_film('My Title');
        $fixture->setId_user('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Location');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Location();
        $fixture->setDate_debut('Value');
        $fixture->setDate_fin('Value');
        $fixture->setId_film('Value');
        $fixture->setId_user('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'location[date_debut]' => 'Something New',
            'location[date_fin]' => 'Something New',
            'location[id_film]' => 'Something New',
            'location[id_user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/location/');

        $fixture = $this->locationRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate_debut());
        self::assertSame('Something New', $fixture[0]->getDate_fin());
        self::assertSame('Something New', $fixture[0]->getId_film());
        self::assertSame('Something New', $fixture[0]->getId_user());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Location();
        $fixture->setDate_debut('Value');
        $fixture->setDate_fin('Value');
        $fixture->setId_film('Value');
        $fixture->setId_user('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/location/');
        self::assertSame(0, $this->locationRepository->count([]));
    }
}
