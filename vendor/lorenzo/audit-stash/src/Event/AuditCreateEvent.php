<?php
declare(strict_types=1);

namespace AuditStash\Event;

/**
 * Represents an audit log event for a newly created record.
 */
class AuditCreateEvent extends BaseEvent
{
    /**
     * Returns the type name of this event object.
     *
     * @return string
     */
    public function getEventType(): string
    {
        return 'create';
    }
}
