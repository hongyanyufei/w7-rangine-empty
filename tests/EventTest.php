<?php

namespace W7\Tests;

use Symfony\Component\Console\Input\ArgvInput;
use W7\Console\Application;
use W7\Core\Dispatcher\EventDispatcher;

class EventTest extends TestCase {

	public function testMakeException() {
		/**
		 * @var Application $application
		 */
		$application = iloader()->singleton(Application::class);
		$command = $application->get('make:listener');

		$command->run(new ArgvInput([
			'input',
			'--name=test'
		]), ioutputer());

		$file = APP_PATH . '/Listener/TestListener.php';

		$this->assertSame(true, file_exists($file));

		unlink($file);
	}

	public function testSet() {
		$event = new EventDispatcher();
		$event->listen('test', function () {
			return 'test';
		});

		$this->assertSame(true, $event->hasListeners('test'));
	}

	public function testMultiEvent() {
		$event = new EventDispatcher();
		$event->listen('test', function () {
			return 'test';
		});
		$event->listen('test', function () {
			return 'test1';
		});
		$event->listen('test', function () {
			return 'test2';
		});

		$this->assertSame('test', $event->dispatch('test')[0]);
		$this->assertSame('test1', $event->dispatch('test')[1]);
		$this->assertSame('test2', $event->dispatch('test')[2]);
	}

	public function testRunAll() {
		$event = new EventDispatcher();
		$event->listen('test', function () {
			return 'test';
		});

		$this->assertSame('test', $event->dispatch('test')[0]);
	}

	public function testRunOne() {
		$event = new EventDispatcher();
		$event->listen('test', function () {
			return 'test';
		});

		$this->assertSame('test', $event->dispatch('test', [], true));
	}
}