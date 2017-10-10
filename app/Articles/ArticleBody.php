<?php


namespace App\Articles;


use App\Products\ProductHtml;
use Symfony\Component\DomCrawler\Crawler;

class ArticleBody
{

    private $html;

    public function __construct($html)
    {
        $this->html = $html;
    }

    public static function html($html)
    {
        return new self($html);
    }

    public function updateTextLink($original_itemid, $new_link)
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent(html_entity_decode($this->html));

        $link_list = $crawler->filter('.amzn-text-link');
        $link_list->each(function($node) use ($original_itemid, $new_link) {
            if(str_contains($node->getNode(0)->getAttribute('href'), $original_itemid)) {
                $node->getNode(0)->setAttribute('href', $new_link);
            }
        });

        return $this->reformattedCrawlerHtml($crawler->html());
    }

    public function replaceProductCard($original, $replacement)
    {
            $crawler = new Crawler();
            $crawler->addHtmlContent(html_entity_decode($this->html));
            $query = '//*[@data-amzn-id="' . $original->itemid . '"]';
            $newproduct = $crawler->filterXPath($query);
            if($newproduct->getNode(0)) {
                $newproduct->getNode(0)->setAttribute('data-amzn-id', $replacement->itemid);
                $newproduct->getNode(0)->nodeValue = $this->makeProductHtml($replacement->toArray());
            }


        return $this->reformattedCrawlerHtml($crawler->html());
    }

    private function makeProductHtml($product)
    {
        return htmlspecialchars(ProductHtml::innerFor($product));
    }

    private function reformattedCrawlerHtml($html)
    {
        $html = html_entity_decode($html);

        return mb_substr($html, 6, -7);
    }


}