<?php
declare(strict_types=1);

namespace AuditStash\Test\TestCase\Persister;

use AuditStash\Action\IndexConfigTrait;
use AuditStash\Event\AuditCreateEvent;
use AuditStash\Event\AuditDeleteEvent;
use AuditStash\Event\AuditUpdateEvent;
use AuditStash\Persister\ElasticSearchPersister;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\DateTime;
use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;

class ElasticSearchPersisterIntegrationTest extends TestCase
{
    use IndexConfigTrait;

    /**
     * Fixtures to be loaded.
     *
     * @var array<string>
     */
    public array $fixtures = [
        'plugin.AuditStash.ElasticArticles',
        'plugin.AuditStash.ElasticAudits',
        'plugin.AuditStash.ElasticAuthors',
        'plugin.AuditStash.ElasticTags',
    ];

    /**
     * Tests that create events are correctly stored.
     *
     * @return void
     * @throws \AuditStash\Exception
     * @throws \Exception
     */
    public function testLogSingleCreateEvent()
    {
        /**
         * @var \Cake\ElasticSearch\Datasource\Connection $client
         */
        $client = ConnectionManager::get('test_elastic');
        $persister = new ElasticSearchPersister(['connection' => $client, 'index' => 'article', 'type' => 'article']);
        $data = [
            'title' => 'A new article',
            'body' => 'article body',
            'author_id' => 1,
            'published' => 'Y',
        ];

        $events[] = new AuditCreateEvent('1234', 50, 'articles', $data, $data, new Entity());
        $persister->logEvents($events);
        $client->getIndex('article')->refresh();

        $articles = $this->getIndexRepository('Article')->find()->toArray();
        $this->assertCount(1, $articles);

        $this->assertEquals(
            new DateTime($events[0]->getTimestamp()),
            new DateTime($articles[0]->get('@timestamp'))
        );

        $expected = [
            'transaction' => '1234',
            'type' => 'create',
            'primary_key' => 50,
            'source' => 'articles',
            'parent_source' => null,
            'original' => [
                'title' => 'A new article',
                'body' => 'article body',
                'author_id' => 1,
                'published' => 'Y',
            ],
            'changed' => [
                'title' => 'A new article',
                'body' => 'article body',
                'author_id' => 1,
                'published' => 'Y',
            ],
            'meta' => [],
        ];
        unset($articles[0]['id'], $articles[0]['@timestamp']);
        $this->assertEquals($expected, $articles[0]->toArray());
    }

    /**
     * Tests that update events are correctly stored.
     *
     * @return void
     * @throws \AuditStash\Exception
     * @throws \Exception
     */
    public function testLogSingleUpdateEvent()
    {
        /**
         * @var \Cake\ElasticSearch\Datasource\Connection $client
         */
        $client = ConnectionManager::get('test_elastic');
        $persister = new ElasticSearchPersister(['connection' => $client, 'index' => 'article', 'type' => 'article']);
        $original = [
            'title' => 'Old article title',
            'published' => 'N',
        ];
        $changed = [
            'title' => 'A new article',
            'published' => 'Y',
        ];

        $events[] = new AuditUpdateEvent('1234', 50, 'articles', $changed, $original, new Entity());
        $events[0]->setParentSourceName('authors');
        $persister->logEvents($events);
        $client->getIndex('article')->refresh();

        $articles = $this->getIndexRepository('Article')->find()->toArray();
        $this->assertCount(1, $articles);

        $this->assertEquals(
            new DateTime($events[0]->getTimestamp()),
            new DateTime($articles[0]->get('@timestamp'))
        );
        $expected = [
            'transaction' => '1234',
            'type' => 'update',
            'primary_key' => 50,
            'source' => 'articles',
            'parent_source' => 'authors',
            'original' => $original,
            'changed' => $changed,
            'meta' => [],
        ];
        unset($articles[0]['id'], $articles[0]['@timestamp']);
        $this->assertEquals($expected, $articles[0]->toArray());
    }

    /**
     * Tests that delete events are correctly stored.
     *
     * @return void
     * @throws \AuditStash\Exception
     * @throws \Exception
     */
    public function testLogSingleDeleteEvent()
    {
        /**
         * @var \Cake\ElasticSearch\Datasource\Connection $client
         */
        $client = ConnectionManager::get('test_elastic');
        $persister = new ElasticSearchPersister(['connection' => $client, 'index' => 'article', 'type' => 'article']);

        $events[] = new AuditDeleteEvent('1234', 50, 'articles', 'authors');
        $persister->logEvents($events);
        $client->getIndex('article')->refresh();

        $articles = $this->getIndexRepository('Article')->find()->toArray();
        $this->assertCount(1, $articles);

        $this->assertEquals(
            new DateTime($events[0]->getTimestamp()),
            new DateTime($articles[0]->get('@timestamp'))
        );

        $expected = [
            'transaction' => '1234',
            'type' => 'delete',
            'primary_key' => 50,
            'source' => 'articles',
            'parent_source' => 'authors',
            'original' => null,
            'changed' => null,
            'meta' => [],
        ];
        unset($articles[0]['id'], $articles[0]['@timestamp']);
        $this->assertEquals($expected, $articles[0]->toArray());
    }

    /**
     * Tests that all events sent to the logger are actually persisted in the same index,
     * althought your source name.
     *
     * @return void
     * @throws \Exception
     */
    public function testLogMultipleEvents()
    {
        /**
         * @var \Cake\ElasticSearch\Datasource\Connection $client
         */
        $client = ConnectionManager::get('test_elastic');
        $persister = new ElasticSearchPersister(['connection' => $client, 'index' => 'audit', 'type' => 'audit']);

        $data = [
            'id' => 3,
            'tag' => 'cakephp',
        ];
        $events[] = new AuditCreateEvent('1234', 4, 'tags', $data, $data, new Entity());

        $original = [
            'title' => 'Old article title',
            'published' => 'N',
        ];
        $changed = [
            'title' => 'A new article',
            'published' => 'Y',
        ];
        $events[] = new AuditUpdateEvent('1234', 2, 'authors', $changed, $original, new Entity());
        $events[] = new AuditDeleteEvent('1234', 50, 'articles');
        $events[] = new AuditDeleteEvent('1234', 51, 'articles');

        $persister->logEvents($events);
        $client->getIndex('audit')->refresh();

        $audits = $this->getIndexRepository('Audit')->find()->all();
        $this->assertCount(4, $audits);
        $audit = $audits->first();
        $this->assertEquals(
            new DateTime($events[0]->getTimestamp()),
            new DateTime($audit->get('@timestamp'))
        );
    }

    /**
     * Tests that Time objects are correctly serialized.
     *
     * @return void
     * @throws \AuditStash\Exception
     * @throws \Exception
     */
    public function testPersistingTimeObjects()
    {
        /**
         * @var \Cake\ElasticSearch\Datasource\Connection $client
         */
        $client = ConnectionManager::get('test_elastic');
        $persister = new ElasticSearchPersister(['connection' => $client, 'index' => 'article', 'type' => 'article']);
        $original = [
            'title' => 'Old article title',
            'published_date' => new DateTime('2015-04-12 20:20:21'),
        ];
        $changed = [
            'title' => 'A new article',
            'published_date' => new DateTime('2015-04-13 20:20:21'),
        ];

        $events[] = new AuditUpdateEvent('1234', 50, 'articles', $changed, $original, new Entity());
        $persister->logEvents($events);
        $client->getIndex('article')->refresh();

        $articles = $this->getIndexRepository('Article')->find()->toArray();
        $this->assertCount(1, $articles);

        $this->assertEquals(
            new DateTime($events[0]->getTimestamp()),
            new DateTime($articles[0]->get('@timestamp'))
        );

        $expected = [
            'transaction' => '1234',
            'type' => 'update',
            'primary_key' => 50,
            'source' => 'articles',
            'parent_source' => null,
            'original' => [
                'title' => 'Old article title',
                'published_date' => '2015-04-12T20:20:21+00:00',
            ],
            'changed' => [
                'title' => 'A new article',
                'published_date' => '2015-04-13T20:20:21+00:00',
            ],
            'meta' => [],
        ];
        unset($articles[0]['id'], $articles[0]['@timestamp']);
        $this->assertEquals($expected, $articles[0]->toArray());
    }

    /**
     * Tests that metadata is correctly stored.
     *
     * @return void
     * @throws \AuditStash\Exception
     */
    public function testLogEventWithMetadata()
    {
        /**
         * @var \Cake\ElasticSearch\Datasource\Connection $client
         */
        $client = ConnectionManager::get('test_elastic');
        $persister = new ElasticSearchPersister(['connection' => $client, 'index' => 'article', 'type' => 'article']);

        $events[] = new AuditDeleteEvent('1234', 50, 'articles', 'authors');
        $events[0]->setMetaInfo(['a' => 'b', 'c' => 'd']);
        $persister->logEvents($events);
        $client->getIndex('article')->refresh();

        $articles = $this->getIndexRepository('Article')->find()->toArray();
        $this->assertCount(1, $articles);
        $this->assertEquals(['a' => 'b', 'c' => 'd'], $articles[0]->meta);
    }
}
