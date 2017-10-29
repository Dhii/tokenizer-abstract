<?php

namespace Dhii\Parser\Tokenizer;

use InvalidArgumentException;
use Exception as RootException;

/**
 * Functionality that allows storage and retrieval of a token.
 *
 * @since [*next-version*]
 */
trait TokenAwareTrait
{
    /**
     * @since [*next-version*]
     *
     * @var TokenInterface|null
     */
    protected $token;

    /**
     * Retrieves the token associated with this instance.
     *
     * @since [*next-version*]
     *
     * @return TokenInterface|null
     */
    protected function _getToken()
    {
        return $this->token;
    }

    /**
     * Assigns a token to this instance.
     *
     * @since [*next-version*]
     *
     * @param TokenInterface|null $token The token.
     */
    protected function _setToken($token)
    {
        if ($token !== null && !($token instanceof TokenInterface)) {
            throw $this->_createInvalidArgumentException($this->__('Invalid token'), null, null, $token);
        }

        $this->token = $token;
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
