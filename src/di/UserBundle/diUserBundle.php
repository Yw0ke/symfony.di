<?php

namespace di\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class diUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
