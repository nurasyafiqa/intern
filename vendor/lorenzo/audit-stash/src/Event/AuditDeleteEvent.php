<?php
declare(strict_types=1);

namespace AuditStash\Event;

use AuditStash\EventInterface;
use Datetime;

/**
 * Represents an audit log event for a newly deleted record.
 */
class AuditDeleteEvent implements EventInterface
{
    use BaseEventTrait;
    use SerializableEventTrait {
        basicSerialize as public jsonSerialize;
    }

    /**
     * Constructor.
     *
     * @param string $transactionId The global transaction id
     * @param mixed $id The primary key record that got deleted
     * @param string $source The name of the source (table) where the record was deleted
     * @param string|null $parentSource The name of the source (table) that triggered this change
     */
    public function __construct(
        string $transactionId,
        mixed $id,
        string $source,
        ?string $parentSource = null
    ) {
        $this->transactionId = $transactionId;
        $this->id = $id;
        $this->source = $source;
        $this->parentSource = $parentSource;
        $this->timestamp = (new DateTime())->format(DateTime::ATOM);
    }

    /**
     * Returns the name of this event type.
     *
     * @return string
     */
    public function getEventType(): string
    {
        return 'delete';
    }
}
