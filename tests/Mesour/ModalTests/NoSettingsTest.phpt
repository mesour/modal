<?php

namespace Mesour\ModalTests;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class NoSettingsTest extends BaseTestCase
{

	public function testDefault()
	{
		// APPLICATION

		$application = new \Mesour\UI\Application('mesourApp');

		$application->setRequest($_REQUEST);

		$application->getConfiguration()
			->setTempDir(__DIR__ . '/tmp');

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

		$modal->addTemplateContent('test4', __DIR__ . '/data/template.latte')
			->setBlock('second');

		$modal->getModalFooter()->disableCloseButton();

		Assert::same(
			file_get_contents(__DIR__ . '/data/NoSettingsTestOutput.html'),
			(string) $modal->render(),
			'Output of modal render doest not match'
		);
	}

}

$test = new NoSettingsTest();
$test->run();
