<?php

namespace Amazing\Media2click\Evaluation;

/**
 * Class UrlSchemeEvaluation
 *
 * Evaluate url scheme in TCA fields
 */
class UrlSchemeEvaluation
{
    /**
     * JavaScript code for client side validation/evaluation
     *
     * @return string JavaScript code for client side validation/evaluation
     */
    public function returnFieldJS()
    {
        $jsCode = [];
        $jsCode[] = 'if(value === \'\') return \'\';';
        $jsCode[] = 'var parser = document.createElement(\'a\');';
        $jsCode[] = 'parser.href = value;';
        $jsCode[] = 'if (parser.protocol === \'https:\' || parser.protocol === \'http:\') return value;';
        $jsCode[] = 'return \'\'';
        return implode(' ', $jsCode);
    }

    /**
     * Server-side validation/evaluation on saving the record
     *
     * @param string $value The field value to be evaluated
     * @param string $is_in The "is_in" value of the field configuration from TCA
     * @param bool $set Boolean defining if the value is written to the database or not.
     * @return string Evaluated field value
     */
    public function evaluateFieldValue($value, $is_in, &$set)
    {
        if (empty($value)) {
            return '';
        }

        $scheme = parse_url($value, PHP_URL_SCHEME);
        if (in_array($scheme, ['https', 'http'])) {
            return $value;
        }

        return '';
    }
}
