<?php

namespace Dhii\Parser\Tokenizer;

use InvalidArgumentException;
use Exception as RootException;

/**
 * Functionality that allows storage and retrieval of a line number.
 *
 * @since [*next-version*]
 */
trait LineNumberAwareTrait
{
    /**
     * @since [*next-version*]
     *
     * @var LineNumberInterface|null
     */
    protected $lineNumber;

    /**
     * Retrieves the line number associated with this instance.
     *
     * @since [*next-version*]
     *
     * @return int|null
     */
    protected function _getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * Assigns a line number to this instance.
     *
     * @since [*next-version*]
     *
     * @param int|string|Stringable|float|null $lineNumber The line number.
     *                                                     Must be a whole positive number.
     */
    protected function _setLineNumber($lineNumber)
    {
        if ($lineNumber !== null) {
            try {
                $lineNumber = $this->_normalizeInt($lineNumber);
            } catch (RootException $e) {
                throw $this->_createInvalidArgumentException($this->__('Invalid line number'), null, $e, $lineNumber);
            }

            if ($lineNumber < 1) {
                throw $this->_createInvalidArgumentException($this->__('Line number must be positive'), null, null, $lineNumber);
            }
        }

        $this->lineNumber = $lineNumber;
    }

    /**
     * Normalizes a value into an integer.
     *
     * The value must be a whole number, or a string representing such a number,
     * or an object representing such a string.
     *
     * @since [*next-version*]
     *
     * @param string|stringable|float|int $value The value to normalize.
     *
     * @throws InvalidArgumentException If value cannot be normalized.
     *
     * @return int The normalized value.
     */
    abstract protected function _normalizeInt($value);

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
