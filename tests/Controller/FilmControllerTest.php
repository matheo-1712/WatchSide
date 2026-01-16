<?php

namespace App\Tests\Controller;

use App\Entity\Film;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FilmControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $filmRepository;
    private string $path = '/film/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->filmRepository = $this->manager->getRepository(Film::class);

        foreach ($this->filmRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Film index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'film[titre]' => 'Testing',
            'film[anne_sortie]' => 'Testing',
            'film[duree]' => 'Testing',
            'film[synopsis]' => 'Testing',
            'film[image]' => 'Testing',
            'film[prix_default]' => 'Testing',
            'film[id_genre]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->filmRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Film();
        $fixture->setTitre('My Title');
        $fixture->setAnne_sortie('My Title');
        $fixture->setDuree('My Title');
        $fixture->setSynopsis('My Title');
        $fixture->setImage('My Title');
        $fixture->setPrix_default('My Title');
        $fixture->setId_genre('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Film');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Film();
        $fixture->setTitre('Value');
        $fixture->setAnne_sortie('Value');
        $fixture->setDuree('Value');
        $fixture->setSynopsis('Value');
        $fixture->setImage('Value');
        $fixture->setPrix_default('Value');
        $fixture->setId_genre('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'film[titre]' => 'Something New',
            'film[anne_sortie]' => 'Something New',
            'film[duree]' => 'Something New',
            'film[synopsis]' => 'Something New',
            'film[image]' => 'Something New',
            'film[prix_default]' => 'Something New',
            'film[id_genre]' => 'Something New',
        ]);

        self::assertResponseRedirects('/film/');

        $fixture = $this->filmRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getAnne_sortie());
        self::assertSame('Something New', $fixture[0]->getDuree());
        self::assertSame('Something New', $fixture[0]->getSynopsis());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getPrix_default());
        self::assertSame('Something New', $fixture[0]->getId_genre());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Film();
        $fixture->setTitre('Value');
        $fixture->setAnne_sortie('Value');
        $fixture->setDuree('Value');
        $fixture->setSynopsis('Value');
        $fixture->setImage('Value');
        $fixture->setPrix_default('Value');
        $fixture->setId_genre('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/film/');
        self::assertSame(0, $this->filmRepository->count([]));
    }
}
