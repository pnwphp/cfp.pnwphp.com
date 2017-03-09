<?php

namespace OpenCFP\Domain;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * This object is responsible for representing behaviour around the call
 * for proposal process. Today it is only responsible for reporting whether or not the
 * CFP is open. This is useful in service-layer testing as you can easily modify the temporal
 * aspect.
 */
class CallForProposal
{
    /**
     * @var DateTimeInterface
     */
    private $endDate;

    public function __construct(DateTimeInterface $end)
    {
        if ($end->format('H:i:s') === '00:00:00') {
            $end = $end->add(new DateInterval('P1D'));
        }
        $this->endDate = $end;
    }

    /**
     * @param DateTimeInterface $currentTime
     *
     * @return boolean true if CFP is open, false otherwise.
     */
    public function isOpen(DateTimeInterface $currentTime = null)
    {
        if (! $currentTime) {
            $currentTime = new DateTimeImmutable('now');
        }

        return $currentTime < $this->endDate;
    }
}
