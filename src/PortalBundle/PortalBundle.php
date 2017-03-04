<?php

namespace PortalBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PortalBundle extends Bundle
{

  public function getParent() {
    return 'FOSUserBundle';
  }
	
}
