<?php

namespace Solari\Drivers;


abstract class SolariDriver 
{
	abstract protected function embed();
	abstract protected function title();
	abstract protected function description();
	abstract protected function img();
}
