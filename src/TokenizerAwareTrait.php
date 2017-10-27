<?php

namespace Dhii\Parser\Tokenizer;

use InvalidArgumentException;
use Exception as RootException;

/**
 * Functionality that allows storage and retrieval of a tokenizer.
 *
 * @since [*next-version*]
 */
trait TokenizerAwareTrait
{
    /**
     * @since [*next-version*]
     *
     * @var TokenizerInterface|null
     */
    protected $tokenizer;

    /**
     * Retrieves the tokenizer associated with this instance.
     *
     * @since [*next-version*]
     *
     * @return TokenizerInterface|null
     */
    protected function _getTokenizer()
    {
        return $this->tokenizer;
    }

    /**
     * Assigns a tokenizer to this instance.
     *
     * @since [*next-version*]
     *
     * @param TokenizerInterface|null $tokenizer The tokenizer.
     */
    protected function _setTokenizer($tokenizer)
    {
        if ($tokenizer !== null && !($tokenizer instanceof TokenizerInterface)) {
            throw $this->_createInvalidArgumentException($this->__('Invalid tokenizer'), null, null, $tokenizer);
        }

        $this->tokenizer = $tokenizer;
    }

    /**
     * Creates a new invalid argument exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable|null $message  The error message, if any.
     * @param int|null               $code     The error code, if any.
     * @param RootException|null     $previous The inner exception for chaining, if any.
     * @param mixed|null             $argument The invalid argument, if any.
     *
     * @return InvalidArgumentException The new exception.
     */
    abstract protected function _createInvalidArgumentException(
        $message = null,
        $code = null,
        RootException $previous = null,
        $argument = null
    );

    /**
     * Translates a string, and replaces placeholders.
     *
     * @since [*next-version*]
     * @see   sprintf()
     *
     * @param string $string  The format string to translate.
     * @param array  $args    Placeholder values to replace in the string.
     * @param mixed  $context The context for translation.
     *
     * @return string The translated string.
     */
    abstract protected function __($string, $args = [], $context = null);
}
