<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/21/16
 * Time: 3:31 PM
 */

namespace ArtsAndHumanities\Http\Controllers;
use ArtsAndHumanities\Http\Transformers\PostTransformer;
use ArtsAndHumanities\Models as Models;
use Corcel\Post;
use Illuminate\Support\Facades\Input as Input;
use League\Fractal\Manager;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Resource\Collection;
class BlogController extends BaseController{


    protected $fractal;

    protected $perPage = 10;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function index(){

        $limit = Input::get('limitBy');

        $posts = Models\ViewPointsPost::status('publish')->orderBy('post_date', 'DESC')->take(5)->get();

        $posts=$this->fractal
            ->createData(new Collection($posts, new PostTransformer))->toArray();


        return view('blog.index')->with('posts',$posts['data']);

    }
}