<?php
declare(strict_types=1);

namespace AuditStash;

/**
 * Represents any object that is capable of persisting an array of
 * EventInterface objects into a storage.
 */
interface PersisterInterface
{
    /**
     * Persists each of the passed EventInterface objects.
     *
     * @param array<\AuditStash\EventInterface> $auditLogs List of EventInterface objects to persist
     * @return void
     */
    public function logEvents(array $auditLogs): void;
}
