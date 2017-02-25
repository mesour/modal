<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/modal)
 *
 * Copyright (c) 2017 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\Modal\Render\Html;

use Mesour;
use Mesour\Modal\Render;

/**
 * @author Matouš Němec <http://mesour.com>
 */
class Content extends Render\Content
{

	public function create()
	{
		$dialogContent = Mesour\Components\Utils\Html::el('div', $this->attributes);

		if ($this->header) {
			$dialogContent->add($this->header->create());
		}
		if ($this->body) {
			$dialogContent->add($this->body->create());
		}
		if ($this->footer) {
			$dialogContent->add($this->footer->create());
		}

		return $dialogContent;
	}

}
