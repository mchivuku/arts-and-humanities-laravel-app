<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/21/16
 * Time: 4:28 PM
 */


namespace ArtsAndHumanities\Http\Transformers;

use ArtsAndHumanities\Models as Models;
use League\Fractal\TransformerAbstract;

class BaseTransformer{


    public function truncateDesc($string, $limit, $url="") {
        if(strlen($string) <= $limit) {
            return $string;
        }
        else {
            $string = substr($string, 0, $limit);
            $string = $this->cleanTags($string." ...", $url);
            //$string.=$url;
            return $string;
        }
    }



    public static function cleanTags($string, $url=""){
         $dom_document = new \DOMDocument();

        @$dom_document->
        loadHTML('
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html
            xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            </head>
            <body>'
            . ($string) . '</body>
        </html>');

        $body_content="";
        $body_node =  $dom_document->getElementsByTagName('body')->item(0);

        foreach ($body_node->childNodes as $child_node) {
            $body_content .= $dom_document->saveHTML($child_node);
        }


        $content= preg_replace('|
        <([^> ]*)/>|i', '
        <$1 />', $body_content);
        //remove empty p tags
        $content= preg_replace('~
        <p>\s*<\/p>~i','',$content);

        $dom_document_append = new \DOMDocument();
        @$dom_document_append->loadHTML('
            <meta http-equiv="content-type" content="text/html; charset=utf-8">'.($content));

        $dom_document_append->encoding = 'UTF-8';
        $DOMParent = $dom_document_append->getElementsByTagName('body')->item(0);

        // Find the parent node
        $xpath = new \DomXPath($dom_document_append);

        // new node will be inserted before this node
        $next =   $xpath->query("p");

        $text = $dom_document_append->createTextNode('...');
        $e = $dom_document_append->createElement('a', 'Read More &#187;');
        $e->setAttribute('href', $url);

        if($url!=""){
            if ($next !== null) {

                $item =$next->item(0);
                if(isset($item)){
                    $DOMParent->lastChild->insertBefore($text, $next->item(0));
                    if($url!="")
                        $DOMParent->lastChild->insertBefore($e, $next->item(0));
                }else{
                    $dom_document_append->lastChild->insertBefore($text);
                    if($url!="")
                        $dom_document_append->lastChild->insertBefore($e);
                }


            }else{

                $dom_document_append->appendChild($text);
                if($url!="")
                    $dom_document_append->appendChild($e);
            }

        }

        return  $dom_document_append->saveXML();
    }

}