<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/modal)
 *
 * Copyright (c) 2017 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\Modal\Render;

/**
 * @author Matouš Němec <http://mesour.com>
 */
abstract class Renderer extends Attributes
{

	/**
	 * @var Content
	 */
	protected $content;

	public function setContent(Content $content)
	{
		$this->content = $content;
	}

	abstract public function create();

}
