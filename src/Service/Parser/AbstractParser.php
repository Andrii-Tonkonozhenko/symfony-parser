<?php

namespace App\Service\Parser;

use DOMXPath;
use DOMDocument;
use DOMNode;

abstract class AbstractParser
{
    public function loadDomXPathFromUrl(string $url): DOMXPath
    {
        $html = file_get_contents($url);

        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        return new DOMXPath($doc);
    }

    protected function getXPathValue(string $xpathQuery, DOMXPath $domXPath, DOMNode $contextNode, ?string $attribute = null): ?string
    {
        $node = $domXPath->query($xpathQuery, $contextNode);

        if ($node->length > 0) {
            return $attribute ? $node->item(0)->getAttribute($attribute) : trim($node->item(0)->textContent);
        }

        return null;
    }
}
