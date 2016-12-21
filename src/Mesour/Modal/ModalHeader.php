<?php
/**
 * This file is part of the Mesour Modal (http://components.mesour.com/component/button)
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
class ModalHeader extends Mesour\Components\Control\AttributesControl
{

	use Mesour\Components\Localization\Translatable;

	const WRAPPER = 'wrapper';
	const TITLE = 'title';
	const CLOSE = 'close';
	private $title;

	/**
	 * @var Mesour\Components\Utils\Html
	 */
	private $disableButtonPrototype;

	/**
	 * @var Mesour\Components\Utils\Html
	 */
	private $titlePrototype;

	public $onRender = [];

	protected $defaults = [
		self::WRAPPER => [
			'el' => 'div',
			'attributes' => [
				'class' => 'modal-header',
			],
		],
		self::TITLE => [
			'el' => 'h4',
			'attributes' => [
				'class' => 'modal-title',
			],
		],
		self::CLOSE => [
			'el' => 'button',
			'attributes' => [
				'type' => 'button',
				'class' => 'close',
				'data-dismiss' => 'modal',
				'aria-label' => 'Close',
			],
			'content' => '<span aria-hidden="true">&times;</span>',
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
	}

	/**
	 * @return Mesour\Components\Utils\Html
	 */
	public function getControlPrototype()
	{
		return $this->getHtmlElement();
	}

	/**
	 * @return Mesour\Components\Utils\Html
	 */
	public function getTitlePrototype()
	{
		return $this->titlePrototype ? $this->titlePrototype : Mesour\Components\Utils\Html::el(
			$this->getOption(self::TITLE, 'el'),
			$this->getOption(self::TITLE, 'attributes')
		);
	}

	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return Mesour\Components\Utils\Html
	 */
	public function getClosePrototype()
	{
		if (!$this->disableButtonPrototype) {
			$this->disableButtonPrototype = Mesour\Components\Utils\Html::el(
				$this->getOption(self::CLOSE, 'el'),
				$this->getOption(self::CLOSE, 'attributes')
			);
			$this->disableButtonPrototype->add($this->getOption(self::CLOSE, 'content'));
		}
		return $this->disableButtonPrototype;
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

		$wrapper->add($this->getClosePrototype());

		if ($this->title) {
			$title = $this->getTitlePrototype();
			$title->setText($this->getTranslator()->translate($this->title));
			$wrapper->add($title);
		}

		foreach ($this->getComponents() as $component) {
			$wrapper->add($component->create());
		}

		$this->onRender($this);

		$this->setHtmlElement($oldWrapper);
		return $wrapper;
	}

}
