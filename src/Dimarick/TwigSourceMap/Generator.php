<?php

namespace Dimarick\TwigSourceMap;

/**
 * Class Generator
 */
class Generator
{
    /**
     * @param \Twig_Template $template
     * @return MapFile
     */
    public function generate(\Twig_Template $template)
    {
        $path = $template->getSourceContext()->getPath();

        $debug = $template->getDebugInfo();
        $output = (new \ReflectionClass($template))->getFileName();

        $map = \Kwf_SourceMaps_SourceMap::createEmptyMap($output);

        foreach ($debug as $outputLine => $sourceLine) {
            $map->addMapping($outputLine, 0, $sourceLine, 0, $path);

        }

        return new MapFile($map->getMapContents(), $output . '.map');
    }
}
