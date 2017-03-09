<?php

namespace OpenCFP\Test;

use OpenCFP\ContainerAware;

class ContainerAwareFake
{
    use ContainerAware;

    /**
     * @param string $slug
     * @return mixed
     */
    public function getService($slug)
    {
        return $this->service($slug);
    }
}
