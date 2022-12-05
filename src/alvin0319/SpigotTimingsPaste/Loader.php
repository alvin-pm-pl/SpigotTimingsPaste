<?php

declare(strict_types=1);

namespace alvin0319\SpigotTimingsPaste;

use alvin0319\SpigotTimingsPaste\command\SpigotTimingsPasteCommand;
use pocketmine\plugin\PluginBase;

final class Loader extends PluginBase{

	protected function onEnable() : void{
		$timingsCommand = $this->getServer()->getCommandMap()->getCommand('timings');
		if($timingsCommand !== null){
			$timingsCommand->setLabel($timingsCommand->getLabel() . '__disabled');
			$this->getServer()->getCommandMap()->unregister($timingsCommand);
			$this->getServer()->getCommandMap()->register('pocketmine', new SpigotTimingsPasteCommand(
				$timingsCommand->getName()
			));
		}
	}
}