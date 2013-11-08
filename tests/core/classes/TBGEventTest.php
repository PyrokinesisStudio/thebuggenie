<?php

//require THEBUGGENIE_CORE_PATH . 'classes/TBGEvent.class.php';
/*
class TBGLogging
{
	public function log($message, $module = '', $level = '')
	{
		
	}
}
*/

/**
 * Test class for TBGEvent.
 * Generated by PHPUnit on 2010-10-05 at 16:55:02.
 */
class TBGEventTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @covers TBGEvent::__construct
	 * @covers TBGEvent::createNew
	 */
	public function testCreateNew()
	{
		$event = TBGEvent::createNew('modulename', 'identifier', 'subject', array('param1' => 1, 'param2' => 2), array('listitem1', 'listitem2'));

		$this->assertInstanceOf('TBGEvent', $event);

		return $event;
	}

	/**
	 * @covers TBGEvent::getIdentifier
	 * @depends testCreateNew
	 */
	public function testGetIdentifier(TBGEvent $event)
	{
		$this->assertEquals('identifier', $event->getIdentifier());
	}

	/**
	 * @covers TBGEvent::getModule
	 * @depends testCreateNew
	 */
	public function testGetModule(TBGEvent $event)
	{
		$this->assertEquals('modulename', $event->getModule());
	}

	/**
	 * @covers TBGEvent::getSubject
	 * @depends testCreateNew
	 */
	public function testGetSubject(TBGEvent $event)
	{
		$this->assertEquals('subject', $event->getSubject());
	}

	/**
	 * @covers TBGEvent::getParameters
	 * @covers TBGEvent::getParameter
	 * @depends testCreateNew
	 */
	public function testParameters(TBGEvent $event)
	{
		$this->assertArrayHasKey('param1', $event->getParameters());
		$this->assertEquals(1, $event->getParameter('param1'));
		$this->assertArrayHasKey('param2', $event->getParameters());
		$this->assertEquals(2, $event->getParameter('param2'));
	}

	/**
	 * @covers TBGEvent::getReturnList
	 * @covers TBGEvent::addToReturnList
	 * @covers TBGEvent::setReturnValue
	 * @covers TBGEvent::getReturnValue
	 * @depends testCreateNew
	 */
	public function testReturnListAndReturnValue(TBGEvent $event)
	{
		$this->assertArrayHasKey(0, $event->getReturnList());
		$this->assertContains('listitem1', $event->getReturnList());
		$this->assertArrayHasKey(1, $event->getReturnList());
		$this->assertContains('listitem2', $event->getReturnList());

		$event->addToReturnList('listitem3');
		$this->assertContains('listitem3', $event->getReturnList());

		$event->setReturnValue('fubar');
		$this->assertEquals('fubar', $event->getReturnValue());

		$event->setReturnValue(null);
		$this->assertEquals(null, $event->getReturnValue());
	}

	/**
	 * @covers TBGEvent::setProcessed
	 * @covers TBGEvent::isProcessed
	 * @depends testCreateNew
	 */
	public function testProcessEvent(TBGEvent $event)
	{
		$event->setProcessed(true);
		$this->assertTrue($event->isProcessed());
		$event->setProcessed(false);
		$this->assertFalse($event->isProcessed());
	}

	public function listenerCallback(TBGEvent $event)
	{
		$this->wastriggered = true;
		return true;
	}

	public function listenerCallbackNonProcessingFirst(TBGEvent $event)
	{
		$this->wasprocessed[] = 1;
		return true;
	}

	public function listenerCallbackNonProcessingSecond(TBGEvent $event)
	{
		$this->wasprocessed[] = 2;
		$event->setProcessed();
		return true;
	}

	public function listenerCallbackProcessing(TBGEvent $event)
	{
		$this->wasprocessed[] = 3;
		return true;
	}

	/**
	 * @covers TBGEvent::listen
	 * @covers TBGEvent::isAnyoneListening
	 * @covers TBGEvent::clearListeners
	 * @depends testCreateNew
	 */
	public function testListening(TBGEvent $event)
	{
		TBGEvent::listen('modulename', 'identifier', array($this, 'listenerCallback'));
		$this->assertTrue(TBGEvent::isAnyoneListening('modulename', 'identifier'));

		TBGEvent::clearListeners('modulename', 'identifier');
		$this->assertFalse(TBGEvent::isAnyoneListening('modulename', 'identifier'));

		TBGEvent::listen('modulename', 'identifier', array($this, 'listenerCallbackNonProcessingFirst'));
		TBGEvent::listen('modulename', 'identifier', array($this, 'listenerCallbackNonProcessingSecond'));
		TBGEvent::listen('modulename', 'identifier', array($this, 'listenerCallbackProcessing'));
		$this->assertTrue(TBGEvent::isAnyoneListening('modulename', 'identifier'));
		
		return $event;
	}

	/**
	 * @covers TBGEvent::listen
	 * @covers TBGEvent::trigger
	 * @covers TBGEvent::triggerUntilProcessed
	 * @depends testListening
	 */
	public function testTriggeringAndProcessing(TBGEvent $event)
	{
		$this->wastriggered = false;
		TBGEvent::clearListeners('modulename', 'identifier');
		TBGEvent::listen('modulename', 'identifier', array($this, 'listenerCallback'));

		$event->trigger();
		$this->assertAttributeEquals(true, 'wastriggered', $this);

		TBGEvent::clearListeners('modulename', 'identifier');
		TBGEvent::listen('modulename', 'identifier', array($this, 'listenerCallbackNonProcessingFirst'));
		TBGEvent::listen('modulename', 'identifier', array($this, 'listenerCallbackNonProcessingSecond'));
		TBGEvent::listen('modulename', 'identifier', array($this, 'listenerCallbackProcessing'));

		$this->wasprocessed = array();
		$event->triggerUntilProcessed();

		$this->assertAttributeNotEmpty('wasprocessed', $this);
		$this->assertAttributeContains(1, 'wasprocessed', $this);
		$this->assertAttributeContains(2, 'wasprocessed', $this);
		$this->assertAttributeNotContains(3, 'wasprocessed', $this);
	}

}
