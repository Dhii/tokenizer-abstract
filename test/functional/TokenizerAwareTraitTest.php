<?php

namespace Dhii\Parser\Tokenizer\UnitTest;

use Xpmock\TestCase;
use Dhii\Parser\Tokenizer\TokenizerAwareTrait as TestSubject;
use Dhii\Parser\Tokenizer\TokenizerInterface;
use PHPUnit_Framework_MockObject_MockObject;
use InvalidArgumentException;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class TokenizerAwareTraitTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Parser\Tokenizer\TokenizerAwareTrait';

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
     * Creates a new token.
     *
     * @since [*next-version*]
     *
     * @return TokenizerInterface The token.
     */
    public function createToken()
    {
        $mock = $this->mock('Dhii\Parser\Tokenizer\TokenizerInterface')
                ->next()
                ->valid()
                ->rewind()
                ->current()
                ->key()
                ->getIteration()
                ->new();

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
     * Tests that `_setTokenizer()` method accepts a token, and `_getTokenizer()` returns it.
     *
     * @since [*next-version*]
     */
    public function testSetGetTokenizer()
    {
        $data = $this->createToken();
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $_subject->_setTokenizer($data);
        $this->assertSame($data, $_subject->_getTokenizer(), 'Token path returned not same as token set');
    }

    /**
     * Tests that `_setTokenizer()` method accepts `null`, and `_getTokenizer()` returns it.
     *
     * @since [*next-version*]
     */
    public function testSetGetTokenizerNull()
    {
        $data = null;
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $_subject->_setTokenizer($data);
        $this->assertEquals($data, $_subject->_getTokenizer(), 'Token path returned not same as token set');
    }

    /**
     * Tests that `_setTokenizer()` method rejects a non-stringable object.
     *
     * @since [*next-version*]
     */
    public function testSetGetTokenizerObject()
    {
        $data = new \stdClass();
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $this->setExpectedException('InvalidArgumentException');
        $_subject->_setTokenizer($data);
    }
}
