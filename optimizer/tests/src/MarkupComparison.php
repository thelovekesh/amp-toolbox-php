<?php

namespace AmpProject\Optimizer\Tests;

/**
 * Compare HTML markup without failing on whitespace or alignment.
 *
 * @package ampproject/optimizer
 */
trait MarkupComparison
{

    /**
     * Assert markup is equal.
     *
     * @param string $expected Expected markup.
     * @param string $actual   Actual markup.
     */
    protected function assertEqualMarkup($expected, $actual)
    {
        // Normalize whitespace (`foo   bar` => `foo bar`).
        $actual   = preg_replace('/\s+/', ' ', $actual);
        $expected = preg_replace('/\s+/', ' ', $expected);

        // Remove whitespace between elements (` <br> <br> ` => `<br><br>`).
        $actual   = preg_replace('/(?<=>)\s+(?=<)/', '', trim($actual));
        $expected = preg_replace('/(?<=>)\s+(?=<)/', '', trim($expected));

        // Split into an array of individual elements.
        $actual   = preg_split('#(<[^>]+>|[^<>]+)#', $actual, -1, PREG_SPLIT_DELIM_CAPTURE);
        $expected = preg_split('#(<[^>]+>|[^<>]+)#', $expected, -1, PREG_SPLIT_DELIM_CAPTURE);

        $this->assertEquals(array_filter($expected), array_filter($actual));
    }

    /**
     * Assert markup is similar, disregarding differences that are inconsequential for functionality.
     *
     * @param string $expected Expected markup.
     * @param string $actual   Actual markup.
     */
    protected function assertSimilarMarkup($expected, $actual)
    {
        // Normalize whitespace (`foo   bar` => `foo bar`).
        $actual   = preg_replace('/\s+/', ' ', $actual);
        $expected = preg_replace('/\s+/', ' ', $expected);

        // Remove whitespace between elements (`<br> <br>` => `<br><br>`).
        $actual   = preg_replace('/(?<=>)\s+(?=<)/', '', trim($actual));
        $expected = preg_replace('/(?<=>)\s+(?=<)/', '', trim($expected));

        // Remove empty values (`foo=""` => `foo`).
        $actual   = preg_replace('/=([\'"]){2}/', '', $actual);
        $expected = preg_replace('/=([\'"]){2}/', '', $expected);

        // Normalize case of doctype element.
        $actual   = preg_replace('/<!doctype/i', '<!DOCTYPE', $actual);
        $expected = preg_replace('/<!doctype/i', '<!DOCTYPE', $expected);

        // Wrap all attributes in quotes (`foo=bar` => `foo="bar"`).
        $actual   = preg_replace('/(\s+[a-zA-Z-_]+)=(?!")([a-zA-Z-_.]+)/', '\1="\2"', $actual);
        $expected = preg_replace('/(\s+[a-zA-Z-_]+)=(?!")([a-zA-Z-_.]+)/', '\1="\2"', $expected);

        // Normalize empty JSON objects (`<script> { } </script>` => `<script>{}</script>`
        $actual   = preg_replace('/>\s*{\s*}\s*</', '>{}<', $actual);
        $expected = preg_replace('/>\s*{\s*}\s*</', '>{}<', $expected);

        $normalizeAttributes = static function ($element) {
            // Extract attributes for the given element.
            if (!preg_match('#^(<[a-z0-9-]+)(\s[^>]+)>$#i', $element, $matches)) {
                return $element;
            }

            // Split into individual attributes.
            $attributes = array_map(
                'trim',
                array_filter(
                    preg_split(
                        '#(\s+[^"\'\s=]+(?:=(?:"[^"]+"|\'[^\']+\'|[^"\'\s]+))?)#',
                        $matches[2],
                        -1,
                        PREG_SPLIT_DELIM_CAPTURE
                    )
                )
            );

            // Normalize sort order.
            sort($attributes);

            $attributeString = implode(' ', $attributes);

            if (!empty($attributeString)) {
                $attributeString = " {$attributeString}";
            }

            return "{$matches[1]}{$attributeString}>";
        };

        // Split into an array of individual elements.
        $actual   = preg_split('#(<[^>]+>|[^<>]+)#', $actual, -1, PREG_SPLIT_DELIM_CAPTURE);
        $expected = preg_split('#(<[^>]+>|[^<>]+)#', $expected, -1, PREG_SPLIT_DELIM_CAPTURE);

        // Normalize the attributes for each individual element.
        $actual   = array_map($normalizeAttributes, array_filter($actual));
        $expected = array_map($normalizeAttributes, array_filter($expected));

        $this->assertEquals($expected, $actual);
    }
}
