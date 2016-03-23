<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/modal)
 *
 * Copyright (c) 2016 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\Modal;

use Mesour;

/**
 * @author Matouš Němec (http://mesour.com)
 *
 * @method Mesour\UI\Control[] getComponents()
 * @method null onRender(ModalFooter $modalFooter)
 */
class ModalFooter extends Mesour\Components\Control\AttributesControl
{

	const WRAPPER = 'wrapper';

	public $onRender = [];

	protected $defaults = [
		self::WRAPPER => [
			'el' => 'div',
			'attributes' => [
				'class' => 'modal-footer',
			],
		],
	];

	public function __construct($name = null, Mesour\Components\ComponentModel\IContainer $parent = null)
	{
		parent::__construct($name, $parent);

		$this->setHtmlElement(
			Mesour\Components\Utils\Html::el(
				$this->getOption(self::WRAPPER, 'el'),
				$this->getOption(self::WRAPPER, 'attributes')
			)
		);

		$this->addComponent(new Mesour\Modal\CloseButton('closeButton'));
	}

	/**
	 * @param string $name
	 * @return Mesour\UI\Button
	 */
	public function addButton($name)
	{
		return new Mesour\UI\Button($name, $this);
	}

	/**
	 * @return Mesour\Components\Utils\Html
	 */
	public function getControlPrototype()
	{
		return $this->getHtmlElement();
	}

	/**
	 * @return Mesour\Modal\CloseButton
	 */
	public function getCloseButton()
	{
		return $this['closeButton'];
	}

	/**
	 * @return Mesour\Modal\CloseButton
	 */
	public function disableCloseButton()
	{
		return $this->getCloseButton()->setDisabled(true);
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

		$closeButton = $this->getCloseButton();
		if (!$closeButton->isDisabled() && $closeButton->isAllowed()) {
			$wrapper->add($this->getCloseButton());
		}

		foreach ($this->getComponents() as $component) {
			if ($component->getName() === 'closeButton') {
				continue;
			}
			$wrapper->add($component->create());
		}

		$this->onRender($this);

		$this->setHtmlElement($oldWrapper);
		return $wrapper;
	}

}
