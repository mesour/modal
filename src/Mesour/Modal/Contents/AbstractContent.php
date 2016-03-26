<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/modal)
 *
 * Copyright (c) 2016 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\Modal\Contents;

use Mesour;

/**
 * @author Matouš Němec (http://mesour.com)
 *
 * @method Mesour\UI\Control[] getComponents()
 * @method Mesour\Modal\ModalBody getParent()
 */
abstract class AbstractContent extends Mesour\Components\Control\AttributesControl
{

	public $onRender = [];

	protected $callback;

	public function setCallback($callback)
	{
		Mesour\Components\Utils\Helpers::checkCallback($callback);
		$this->callback = $callback;
	}

}
