<?php

namespace Dhii\Parser\Tokenizer;

use InvalidArgumentException;
use Exception as RootException;

/**
 * Functionality that allows storage and retrieval of a column number.
 *
 * @since [*next-version*]
 */
trait ColumnNumberAwareTrait
{
    /**
     * @since [*next-version*]
     *
     * @var ColumnNumberInterface|null
     */
    protected $columnNumber;

    /**
     * Retrieves the column number associated with this instance.
     *
     * @since [*next-version*]
     *
     * @return int|null The 1-based column number.
     */
    protected function _getColumnNumber()
    {
        return $this->columnNumber;
    }

    /**
     * Assigns a column number to this instance.
     *
     * @since [*next-version*]
     *
     * @param int|string|Stringable|float|null $columnNumber The column number.
     *                                                       Must be a whole positive number.
     */
    protected function _setColumnNumber($columnNumber)
    {
        if ($columnNumber !== null) {
            try {
                $columnNumber = $this->_normalizeInt($columnNumber);
            } catch (RootException $e) {
                throw $this->_createInvalidArgumentException($this->__('Invalid column number'), null, $e, $columnNumber);
            }

            if ($columnNumber < 1) {
                throw $this->_createInvalidArgumentException($this->__('Column number must be positive'), null, null, $columnNumber);
            }
        }

        $this->columnNumber = $columnNumber;
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
