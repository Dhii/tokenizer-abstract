<?php

namespace Dhii\Parser\Tokenizer\UnitTest;

use Xpmock\TestCase;
use Dhii\Parser\Tokenizer\LineNumberAwareTrait as TestSubject;
use PHPUnit_Framework_MockObject_MockObject;
use InvalidArgumentException;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class LineNumberAwareTraitTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Parser\Tokenizer\LineNumberAwareTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function createInstance()
    {
        $mock = $this->getMockForTrait(static::TEST_SUBJECT_CLASSNAME);
        $mock->method('_createInvalidArgumentException')
                ->will($this->returnCallback(function ($message = null) {
                    return $this->createInvalidArgumentException($message);
                }));
        $mock->method('__')
                ->will($this->returnArgument(0));
        $mock->method('_normalizeInt')
                ->will($this->returnCallback(function ($num) {
                    return (int) $num;
                }));

        return $mock;
    }

    /**
     * Creates a validation failed exception for testing purposes.
     *
     * @since [*next-version*]
     *
     * @param string $message The error message.
     *
     * @return InvalidArgumentException
     */
    public function createInvalidArgumentException($message = '')
    {
        $mock = $this->mock('InvalidArgumentException')
                ->new($message);

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInternalType(
            'object',
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests that `_setLineNumber()` method accepts a positive integer, and `_getLineNumber()` returns it.
     *
     * @since [*next-version*]
     */
    public function testSetGetLineNumberInt()
    {
        $data = rand(0, 99);
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $_subject->_setLineNumber($data);
        $this->assertSame($data, $_subject->_getLineNumber(), 'Line number returned not same as line number set');
    }

    /**
     * Tests that `_setLineNumber()` method accepts null, and `_getLineNumber()` returns it.
     *
     * @since [*next-version*]
     */
    public function testSetGetLineNumberNull()
    {
        $data = null;
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $_subject->_setLineNumber($data);
        $this->assertSame($data, $_subject->_getLineNumber(), 'Line number returned not same as line number set');
    }

    /**
     * Tests that `_setLineNumber()` method rejects a negative value.
     *
     * @since [*next-version*]
     */
    public function testSetGetLineNumberIntZeroFailure()
    {
        $data = rand(0, 99) * -1;
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $this->setExpectedException('InvalidArgumentException');
        $_subject->_setLineNumber($data);
    }
    /**
     * Tests that `_setLineNumber()` method rejects a zero value.
     *
     * @since [*next-version*]
     */
    public function testSetGetLineNumberIntNegativeFailure()
    {
        $data = 0;
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $this->setExpectedException('InvalidArgumentException');
        $_subject->_setLineNumber($data);
    }

    /**
     * Tests that `_setLineNumber()` method rejects an invalid value.
     *
     * @since [*next-version*]
     */
    public function testSetGetLineNumberFailure()
    {
        $data = uniqid('string-');
        $subject = $this->createInstance();
        $subject->method('_normalizeInt')
                ->will($this->throwException($this->createInvalidArgumentException()));
        $_subject = $this->reflect($subject);

        $this->setExpectedException('InvalidArgumentException');
        $_subject->_setLineNumber($data);
    }
}
