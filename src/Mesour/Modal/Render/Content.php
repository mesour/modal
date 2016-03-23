<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/modal)
 *
 * Copyright (c) 2016 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\Modal\Render;

use Mesour\Modal;

/**
 * @author Matouš Němec <http://mesour.com>
 */
abstract class Content extends Attributes
{

	/**
	 * @var Modal\ModalHeader
	 */
	protected $header;

	/**
	 * @var Modal\ModalBody
	 */
	protected $body;

	/**
	 * @var Modal\ModalFooter
	 */
	protected $footer;

	public function setHeader(Modal\ModalHeader $header)
	{
		$this->header = $header;
	}

	public function setBody(Modal\ModalBody $body)
	{
		$this->body = $body;
	}

	public function setFooter(Modal\ModalFooter $footer)
	{
		$this->footer = $footer;
	}

	abstract public function create();

}
