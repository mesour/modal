<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/modal)
 *
 * Copyright (c) 2016 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\UI;

use Mesour;
use Nette\InvalidStateException;

/**
 * @author Matouš Němec (http://mesour.com)
 *
 * @method null onBeforeRender(Modal $editable, Mesour\Components\Utils\Html $wrapper)
 * @method null onRender(Modal $editable)
 */
class Modal extends Mesour\Components\Control\AttributesControl
{

	const WRAPPER = 'wrapper';

	const DIALOG = 'dialog';

	const CONTENT = 'content';

	private $disabled = false;

	private $isRendererFactoryUsed = false;

	/**
	 * @var Mesour\Modal\Render\IRendererFactory
	 */
	private $rendererFactory;

	private $showed = false;

	private $backdrop = true;

	private $keyboard = true;

	public $onBeforeRender = [];

	public $onRender = [];

	protected $defaults = [
		self::WRAPPER => [
			'el' => 'div',
			'attributes' => [
				'class' => 'modal fade',
				'tabindex' => '-1',
				'role' => 'dialog',
			],
		],
		self::DIALOG => 'modal-dialog',
		self::CONTENT => 'modal-content',
	];

	public function __construct($name = null, Mesour\Components\ComponentModel\IContainer $parent = null)
	{
		if (is_null($name)) {
			throw new Mesour\InvalidStateException('Component name is required.');
		}
		parent::__construct($name, $parent);

		$this->setHtmlElement(
			Mesour\Components\Utils\Html::el(
				$this->getOption(self::WRAPPER, 'el'),
				$this->getOption(self::WRAPPER, 'attributes')
			)
		);

		$this->addComponent(new Mesour\Modal\ModalHeader('modalHeader'));
		$this->addComponent(new Mesour\Modal\ModalBody('modalBody'));
		$this->addComponent(new Mesour\Modal\ModalFooter('modalFooter'));
	}

	/**
	 * @return Mesour\Components\Utils\Html
	 */
	public function getControlPrototype()
	{
		return $this->getHtmlElement();
	}

	/**
	 * @return Mesour\Modal\ModalHeader
	 */
	public function getModalHeader()
	{
		return $this['modalHeader'];
	}

	/**
	 * @return Mesour\Modal\ModalBody
	 */
	public function getModalBody()
	{
		return $this['modalBody'];
	}

	/**
	 * @return Mesour\Modal\ModalFooter
	 */
	public function getModalFooter()
	{
		return $this['modalFooter'];
	}

	public function setRendererFactory(Mesour\Modal\Render\IRendererFactory $rendererFactory)
	{
		if ($this->isRendererFactoryUsed) {
			throw new InvalidStateException('Can not set renderer factory after modal is created.');
		}
		$this->rendererFactory = $rendererFactory;
		return $this;
	}

	protected function useRendererFactory()
	{
		$this->isRendererFactoryUsed = true;
	}

	public function getRendererFactory()
	{
		if (!$this->rendererFactory) {
			$this->setRendererFactory(new Mesour\Modal\Render\Html\RendererFactory());
		}
		return $this->rendererFactory;
	}

	public function setDisabled($disabled = true)
	{
		$this->disabled = (bool) $disabled;
		return $this;
	}

	public function setTitle($title)
	{
		$this->getModalHeader()->setTitle($title);
		return $this;
	}

	public function showModal()
	{
		$this->showed = true;
		return $this;
	}

	public function hideModal()
	{
		$this->showed = false;
		return $this;
	}

	public function disableBackdrop()
	{
		$this->backdrop = false;
		return $this;
	}

	public function disableKeyboard()
	{
		$this->keyboard = false;
		return $this;
	}

	public function isDisabled()
	{
		return $this->disabled;
	}

	public function create()
	{
		parent::create();

		$wrapper = $this->getControlPrototype();
		$oldWrapper = clone $wrapper;
		foreach ($oldWrapper->attrs as $key => $attr) {
			if (is_object($attr)) {
				$oldWrapper->attrs[$key] = clone $attr;
			}
		}

		$this->onBeforeRender($this, $wrapper);

		$rendererFactory = $this->getRendererFactory();
		$this->useRendererFactory();

		$dialog = $rendererFactory->createDialog();
		$dialog->setAttribute('class', $this->getOption(self::DIALOG), true);

		$header = $this->getModalHeader();
		$body = $this->getModalBody();
		$footer = $this->getModalFooter();

		$content = $rendererFactory->createContent();
		$content->setAttribute('class', $this->getOption(self::CONTENT), true);

		$content->setHeader($header);
		$content->setBody($body);
		$content->setFooter($footer);

		$dialog->setContent($content);

		$wrapper->add($dialog->create());
		$wrapper->addAttributes(
			[
				'data-mesour-modal' => $this->createLinkName(),
				'data-show' => $this->showed ? 'true' : 'false',
				'data-keyboard' => $this->keyboard ? 'true' : 'false',
				'data-backdrop' => $this->backdrop ? 'true' : 'false',
			]
		);

		$this->onRender($this);

		$this->setHtmlElement($oldWrapper);
		return $wrapper;
	}

}
