<?php

namespace Mesour\ModalTests;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class HandlerTest extends BaseTestCase
{

	public function testDefault()
	{
		// APPLICATION

		$application = new \Mesour\UI\Application('mesourApp');

		$application->setRequest([
			'm_do' => 'mesourApp-testModal-modalBody-getContent',
		]);

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

		$modal->addTemplateContent('test4', __DIR__ . '/data/template.latte')
			->setBlock('second');

		$modal->getModalFooter()->disableCloseButton();

		Assert::same(
			"test content<br>     67890\n",
			$modal->getModalBody()->getContent(true),
			'Output of modal render doest not match'
		);
	}

}

$test = new HandlerTest();
$test->run();
