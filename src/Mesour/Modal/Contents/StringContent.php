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
 * @method null onRender(StringContent $content)
 */
class StringContent extends AbstractContent
{

	public function create($isAjax = false)
	{
		parent::create();

		if (!$this->callback) {
			throw new Mesour\InvalidStateException('Callback is required for string content.');
		}

		if (!$isAjax && $this->getParent()->hasAjaxLoading()) {
			return '';
		}

		$this->onRender($this);

		return Mesour\Components\Utils\Helpers::invokeArgs($this->callback, [$this]);
	}

}
