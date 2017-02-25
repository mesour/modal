<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/modal)
 *
 * Copyright (c) 2017 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\Modal;

use Mesour;

/**
 * @author Matouš Němec <http://mesour.com>
 */
class CloseButton extends Mesour\UI\Button
{

	public function __construct($name = null, Mesour\Components\ComponentModel\IContainer $parent = null)
	{
		$this->defaults[self::WRAPPER]['el'] = 'button';
		$this->defaults[self::WRAPPER]['attributes']['data-dismiss'] = 'modal';

		$this->setText('Close');

		parent::__construct($name, $parent);
	}

}
