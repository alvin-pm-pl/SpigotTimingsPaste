<?php

declare(strict_types=1);

namespace alvin0319\SpigotTimingsPaste\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\TimingsCommand;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\scheduler\AsyncTask;
use pocketmine\timings\TimingsHandler;
use pocketmine\utils\Internet;
use pocketmine\utils\TextFormat;
use function implode;
use function json_decode;

final class SpigotTimingsPasteCommand extends TimingsCommand{
	public function execute(CommandSender $sender, string $commandLabel, array $args) : void{
		if(!$this->testPermission($sender)){
			return;
		}
		if(strtolower($args[0] ?? '') !== 'paste'){
			parent::execute($sender, $commandLabel, $args);
			return;
		}

		if(!TimingsHandler::isEnabled()){
			$sender->sendMessage(KnownTranslationFactory::pocketmine_command_timings_timingsDisabled()->prefix(TextFormat::RED));
			return;
		}

		$data = implode("\n", TimingsHandler::printTimings());
		$sender->getServer()->getAsyncPool()->submitTask(new class($sender, $data) extends AsyncTask{

			public const KEY_SENDER = 'sender';

			public function __construct(CommandSender $sender, private string $data){
				$this->storeLocal(self::KEY_SENDER, $sender);
			}

			public function onRun() : void{
				$data = Internet::postURL('https://timings.spigotmc.org/paste', $this->data, 1000);
				if($data->getCode() !== 200){
					$this->setResult(null);
					return;
				}
				$this->setResult($data->getBody());
			}

			public function onCompletion() : void{
				/** @var CommandSender $sender */
				$sender = $this->fetchLocal(self::KEY_SENDER);
				$data = json_decode($this->getResult(), true);
				$message = KnownTranslationFactory::pocketmine_command_timings_timingsUpload('https://timings.spigotmc.org/?url=' . $data['key']);

				Command::broadcastCommandMessage($sender, $message);
			}
		});
	}
}