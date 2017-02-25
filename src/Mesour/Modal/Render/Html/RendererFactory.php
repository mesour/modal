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
class RendererFactory implements Render\IRendererFactory
{

	public function createContent()
	{
		return new Content();
	}

	public function createDialog()
	{
		return new Renderer();
	}

}
