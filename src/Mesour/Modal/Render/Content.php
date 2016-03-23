<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/modal)
 *
 * Copyright (c) 2016 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\Modal\Render;

use Mesour\Modal\ModalHeader;
use Mesour\Modal\ModalBody;
use Mesour\Modal\ModalFooter;

/**
 * @author Matouš Němec <http://mesour.com>
 */
abstract class Content extends Attributes
{

	/**
	 * @var ModalHeader
	 */
	protected $header;

	/**
	 * @var ModalBody
	 */
	protected $body;

	/**
	 * @var ModalFooter
	 */
	protected $footer;

	public function setHeader(ModalHeader $header)
	{
		$this->header = $header;
	}

	public function setBody(ModalBody $body)
	{
		$this->body = $body;
	}

	public function setFooter(ModalFooter $footer)
	{
		$this->footer = $footer;
	}

	abstract public function create();

}