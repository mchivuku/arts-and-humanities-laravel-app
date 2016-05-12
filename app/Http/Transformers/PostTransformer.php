<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/21/16
 * Time: 4:27 PM
 */


namespace ArtsAndHumanities\Http\Transformers;

use ArtsAndHumanities\Models as Models;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{

    protected $base_transformer;
    public function __construct()
    {

        $this->base_transformer = new BaseTransformer();

    }

    public function transform(Models\ViewPointsPost $post)
    {

        $doc = new \DOMDocument();
        $doc->loadHTML("<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">".$post->post_content);
        $xpath = new \DOMXPath($doc);
        foreach ($xpath->query('//img') as $node) {
            $node->parentNode->removeChild($node);
        }

        $html = preg_replace('#\s*\[caption[^]]*\].*?\[/caption\]\s*#is', '',
            $doc->saveHTML());

        // get all image tags in the content.
        $img="";
        preg_match_all('/<img[^>]+>/i',$post->content, $img);

        //for ($i = 0; $i < count($img); $i++) {
          //  preg_match('/src="([^"]+)/i',$img[0][$i], $image);
           // $src[] = str_ireplace( 'src="', '',  $image[0]);
        //}

        //$src_image =current($src);

        return [
            'guid' => $post->guid,
            'post_title'=>$post->post_title,
            'post_content' => $this->base_transformer->truncateDesc($html,500),
            'post_date'=>date('l, F j, Y',strtotime($post->post_date)),
            'post_image'=>isset($img[0][0])?$img[0][0]:""

        ];
    }
}