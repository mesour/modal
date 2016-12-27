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

	/**
	 * @param string $tempDir
	 * @deprecated
	 */
	public function setTempDir($tempDir)
	{
		trigger_error('Deprecated. Use $application->getConfiguration()->setTempDir($tempDir) instead.', E_USER_DEPRECATED);
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
			$configTempDir = $this->getApplication()->getConfiguration()->getTempDir();
			if (!$configTempDir) {
				throw new Mesour\InvalidStateException('Temp dir is required.');
			}
			$this->templateFile = new Mesour\UI\TemplateFile($this->getEngine(), $configTempDir, $this->getTranslator());
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
