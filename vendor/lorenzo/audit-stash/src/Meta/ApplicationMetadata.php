<?php
declare(strict_types=1);

namespace AuditStash\Meta;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

/**
 * Event listener that is capable of enriching the audit logs
 * with general information about the application where the change happened.
 */
class ApplicationMetadata implements EventListenerInterface
{
    /**
     * Extra application details to be passed to the audit logs.
     *
     * @var array
     */
    protected array $data;

    /**
     * Constructor.
     *
     * @param array $data The extra application data to be copied to
     * each audit log event.
     */
    public function __construct(string $name, array $data = [])
    {
        $this->data = ['app_name' => $name] + $data;
    }

    /**
     * Returns an array with the events this class listens to.
     *
     * @return array
     */
    public function implementedEvents(): array
    {
        return ['AuditStash.beforeLog' => 'beforeLog'];
    }

    /**
     * Enriches all the passed audit logs to add the request info metadata.
     *
     * @param \Cake\Event\Event $event The AuditStash.beforeLog event
     * @param array $logs The audit log event objects
     * @return void
     */
    public function beforeLog(Event $event, array $logs): void
    {
        foreach ($logs as $log) {
            $log->setMetaInfo($log->getMetaInfo() + $this->data);
        }
    }
}
