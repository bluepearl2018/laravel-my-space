<?php

namespace Eutranet\MySpace\Console\Commands;

use Eutranet\Init\Console\Commands\InstallPackageCommand;

class EutranetInstallMySpaceCommand extends InstallPackageCommand
{

	public function __construct()
	{
		$this->signature = 'eutranet:install-my-space';
		parent::__construct('my-space', $this->signature);
	}

}
