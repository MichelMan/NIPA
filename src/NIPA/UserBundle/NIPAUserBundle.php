<?php

namespace NIPA\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NIPAUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
