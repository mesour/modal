<?php

namespace Mesour\ModalTests;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class DefaultTest extends BaseTestCase
{

	public function testDefault()
	{
		// APPLICATION

		$application = new \Mesour\UI\Application('mesourApp');

		$application->setRequest($_REQUEST);

		$application->run();

		// MODAL

		$modal = new \Mesour\UI\Modal('testModal', $application);

		$modal->setTitle('Test modal');

		$modal->addStringContent('test')
			->setCallback(
				function (\Mesour\Modal\Contents\StringContent $content) {
					return 'test content<br>';
				}
			);

		$modal->addStringContent('test2')
			->setCallback(
				function (\Mesour\Modal\Contents\StringContent $content) {
					return 'test content 2<br>';
				}
			);

		$modal->addTemplateContent('test3', __DIR__ . '/template.latte')
			->setTempDir(__DIR__ . '/tmp')
			->setBlock('first')
			->setCallback(
				function (\Mesour\Modal\Contents\TemplateContent $content, \Mesour\UI\TemplateFile $template) {
					$template->foo = 'foo variable content';
				}
			);

		$modal->addTemplateContent('test4', __DIR__ . '/template.latte')
			->setTempDir(__DIR__ . '/tmp')
			->setBlock('second');

		$modal->showModal();

		$modal->setAjaxLoading();

		$modal->setCached();

		$modal->getModalFooter()->addButton('testButton')
			->setType('primary')
			->setText('Save');

		Assert::same(
			file_get_contents(__DIR__ . '/data/DefaultTestOutput.html'),
			(string) $modal->render(),
			'Output of modal render doest not match'
		);
	}

}

$test = new DefaultTest();
$test->run();
