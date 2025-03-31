<?php

declare(strict_types=1);

namespace ClickedTran\mineral\libs\muqsit\invmenu\type\util\builder;

use ClickedTran\mineral\libs\muqsit\invmenu\type\InvMenuType;

interface InvMenuTypeBuilder{

	public function build() : InvMenuType;
}