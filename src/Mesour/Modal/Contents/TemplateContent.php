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
 * @method null onRender(TemplateContent $content, Mesour\UI\TemplateFile $template)
 */
class TemplateContent extends AbstractContent
{

	private $file;

	private $block;

	/**
	 * @var Mesour\Template\ITemplate
	 */
	private $templateEngine;

	/**
	 * @var Mesour\UI\TemplateFile
	 */
	private $templateFile;

	public function setTempDir($tempDir)
	{
		$this->templateFile = new Mesour\UI\TemplateFile($this->getEngine(), $tempDir);
		return $this;
	}

	public function setBlock($block)
	{
		$this->block = $block;
		return $this;
	}

	public function setFile($file)
	{
		$this->file = $file;
		return $this;
	}

	public function setTemplateEngine(Mesour\Template\ITemplate $template)
	{
		$this->templateEngine = $template;
	}

	public function getEngine()
	{
		if (!$this->templateEngine) {
			$this->templateEngine = new Mesour\Template\Latte\LatteTemplate();
		}
		return $this->templateEngine;
	}

	public function create($isAjax = false)
	{
		parent::create();

		if (!$isAjax && $this->getParent()->hasAjaxLoading()) {
			return '';
		}

		$template = $this->getTemplateFile();

		if ($this->callback) {
			Mesour\Components\Utils\Helpers::invokeArgs($this->callback, [$this, $template]);
		}

		$this->onRender($this, $template);

		return $template->render(true);
	}

	protected function getTemplateFile()
	{
		if (!$this->templateFile) {
			throw new Mesour\InvalidStateException('Temp dir is required. User setTempDir.');
		}
		if (!$this->file) {
			throw new Mesour\InvalidStateException('Template file is required. User setFile.');
		} else {
			$this->templateFile->setFile($this->file);
		}
		if ($this->block) {
			$this->templateFile->setBlock($this->block);
		}
		return $this->templateFile;
	}

}
