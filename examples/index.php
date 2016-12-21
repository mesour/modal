<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
	  integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<?php

define('SRC_DIR', __DIR__ . '/../src/');

require_once __DIR__ . '/../vendor/autoload.php';

\Tracy\Debugger::enable(\Tracy\Debugger::DEVELOPMENT, __DIR__ . '/log');
\Tracy\Debugger::$strictMode = true;

require_once SRC_DIR . 'Mesour/Modal/Render/IRendererFactory.php';
require_once SRC_DIR . 'Mesour/Modal/Render/Attributes.php';
require_once SRC_DIR . 'Mesour/Modal/Render/Content.php';
require_once SRC_DIR . 'Mesour/Modal/Render/Renderer.php';

require_once SRC_DIR . 'Mesour/Modal/Render/Html/Content.php';
require_once SRC_DIR . 'Mesour/Modal/Render/Html/Renderer.php';
require_once SRC_DIR . 'Mesour/Modal/Render/Html/RendererFactory.php';

require_once SRC_DIR . 'Mesour/Modal/Contents/AbstractContent.php';
require_once SRC_DIR . 'Mesour/Modal/Contents/StringContent.php';
require_once SRC_DIR . 'Mesour/Modal/Contents/TemplateContent.php';

require_once SRC_DIR . 'Mesour/Modal/CloseButton.php';
require_once SRC_DIR . 'Mesour/Modal/ModalHeader.php';
require_once SRC_DIR . 'Mesour/Modal/ModalBody.php';
require_once SRC_DIR . 'Mesour/Modal/ModalFooter.php';
require_once SRC_DIR . 'Mesour/UI/Modal.php';

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

echo $modal->render();

?>

<div class="container">

	<hr>

	<a href="#" class="btn btn-primary btn-lg" data-modal-show="<?php echo $modal->createLinkName(); ?>">
		Launch modal
	</a>

	<hr>

</div>

<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
		integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
		crossorigin="anonymous"></script>

<script src="../node_modules/mesour-modal/dist/mesour.modal.min.js"></script>

<script>
	$(function () {
		$(document).on('click', '[data-modal-show]', function (e) {
			e.preventDefault();

			var name = $(this).attr('data-modal-show');

			mesour.modal.show(name);
		});
	});
</script>