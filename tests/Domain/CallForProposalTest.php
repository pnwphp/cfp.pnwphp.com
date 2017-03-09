<?php

namespace OpenCFP\Test\Domain;

use DateTime;
use OpenCFP\Domain\CallForProposal;

class CallForProposalTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @dataProvider stillOpenCfPsProvider
     */
    public function it_should_tell_whether_or_not_the_cfp_is_open($endDate)
    {
        $cfp = new CallForProposal(new DateTime($endDate));
        $this->assertTrue($cfp->isOpen());
    }

    public function stillOpenCfPsProvider()
    {
        return [
            ['+1 day'],
            [(new \DateTimeImmutable())->format('d.m.Y')],
        ];
    }

    /** @test */
    public function it_should_say_cfp_is_closed_after_end_date_has_passed()
    {
        $cfp = new CallForProposal(new DateTime('-1 day'));
        $this->assertFalse($cfp->isOpen());
    }
}
