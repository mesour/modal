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
use Nette\Utils\Strings;

/**
 * @author Matouš Němec (http://mesour.com)
 *
 * @method Mesour\UI\Control[] getComponents()
 * @method null onRender(ModalFooter $modalFooter)
 */
class ModalBody extends Mesour\Components\Control\AttributesControl
{

	const WRAPPER = 'wrapper';

	private $ajaxLoading = false;

	private $cached = false;

	public $onRender = [];

	protected $defaults = [
		self::WRAPPER => [
			'el' => 'div',
			'attributes' => [
				'class' => 'modal-body',
				'mesour-modal-body' => 'true',
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
	}

	public function setAjaxLoading($ajaxLoading = true)
	{
		$this->ajaxLoading = $ajaxLoading;
		return $this;
	}

	public function setCached($cached = true)
	{
		$this->cached = $cached;
		return $this;
	}

	public function hasAjaxLoading()
	{
		return $this->ajaxLoading;
	}

	/**
	 * @return Mesour\Components\Utils\Html
	 */
	public function getControlPrototype()
	{
		return $this->getHtmlElement();
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

		if ($this->ajaxLoading) {
			$application = $this->lookup(Mesour\Components\Application\IApplication::class, false, true);
			if (!$application) {
				throw new Mesour\InvalidStateException(
					sprintf(
						'If use ajax loading, modal component must be attached to %s.',
						Mesour\UI\Application::class
					)
				);
			}
		}

		$wrapper->addAttributes(
			[
				'data-ajax-loading' => $this->ajaxLoading ? $this->createLinkName() : 'false',
				'data-is-cached' => $this->cached ? 'true' : 'false',
			]
		);

		$wrapper->add($this->getContent());

		$this->onRender($this);

		$this->setHtmlElement($oldWrapper);
		return $wrapper;
	}

	public function handleGetContent()
	{
		ob_clean();
		ob_start();
		echo $this->getContent(true);
		$out = ob_get_contents();
		ob_end_clean();
		echo trim($out);
		exit(0);
	}

	private function getContent($isAjax = false)
	{
		$out = '';

		/** @var Mesour\UI\Control[] $components */
		$components = array_values($this->getComponents());
		$count = count($components);
		foreach ($components as $key => $component) {
			$output = (string) $component->create($isAjax);
			if (Strings::length($output) > 0) {
				$out .= $output;
				if ($count !== $key + 1) {
					$out .= ' ';
				}
			}
		}
		return $out;
	}

}
