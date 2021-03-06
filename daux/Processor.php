<?php 

namespace Todaymade\Daux\Extension;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\HtmlBlock;
use League\CommonMark\Block\Parser\AbstractBlockParser;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Environment;
use League\CommonMark\HtmlElement;

class Processor extends \Todaymade\Daux\Processor
{
    public function extendCommonMarkEnvironment(Environment $environment)
    {
        $environment->addBlockParser(new CalloutParser());
        //$environment->addBlockRenderer('League\CommonMark\Block\Element\BlockQuote', new CustomBlockQuoteRenderer());
    }
}

class CalloutParser extends AbstractBlockParser
{
    public function parse(ContextInterface $context, Cursor $cursor) {
        if ($cursor->isIndented()) {
            return false;
        }

        if ($cursor->advanceWhileMatches('!') != 2) {
            return false;
        }

        $cursor->advanceToNextNonSpaceOrTab();
        $pos = $cursor->getPosition();
        $length = $cursor->advanceToEnd();

        $html = new HtmlElement(
            'div',
            ['class' => 'bs-callout bs-callout-primary'], 
            substr($cursor->getLine(), $pos, $length)
        ); 

        $block = new HtmlBlock(6);
        $block->addLine($html->__toString());

        $context->addBlock($block);

        return true;
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