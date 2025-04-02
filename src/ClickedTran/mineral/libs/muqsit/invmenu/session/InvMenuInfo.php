<?php

declare(strict_types=1);

namespace ClickedTran\mineral\libs\muqsit\invmenu\session;

use ClickedTran\mineral\libs\muqsit\invmenu\InvMenu;
use ClickedTran\mineral\libs\muqsit\invmenu\type\graphic\InvMenuGraphic;

final class InvMenuInfo{

	public function __construct(
		readonly public InvMenu $menu,
		readonly public InvMenuGraphic $graphic,
		readonly public ?string $graphic_name
	){}
}