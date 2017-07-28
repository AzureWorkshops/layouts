<?php 

namespace Todaymade\Daux\Extension;

use Todaymade\Daux\Tree\Root;

class Processor extends \Todaymade\Daux\Processor
{
    public function extendCommonMarkEnvironment(Environment $environment)
    {
        $environment->addBlockRenderer('League\CommonMark\Block\Element\BlockQuote', new CustomBlockQuoteRenderer());
    }
}

class CustomBlockQuoteRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        if (!($block instanceof BlockQuote)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        $filling = $htmlRenderer->renderBlocks($block->children());
        if ($filling === '') {
            return new HtmlElement('blockquote', $attrs, $htmlRenderer->getOption('inner_separator', "\n"));
        }

        return new HtmlElement(
            'div',
            ['class' => 'bs-callout bs-callout-primary'],
            $htmlRenderer->getOption('inner_separator', "\n") . $filling . $htmlRenderer->getOption('inner_separator', "\n")
        );
    }
}