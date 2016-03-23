<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/modal)
 *
 * Copyright (c) 2016 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\Modal\Render;

/**
 * @author Matouš Němec <http://mesour.com>
 */
interface IRendererFactory
{

	/**
	 * @return Content
	 */
	public function createContent();

	/**
	 * @return Renderer
	 */
	public function createDialog();

}
