<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\PageContentModel;
use App\Models\PageModel;
use App\Models\ContentModel;

class Home extends BaseController
{
    protected $articleModel;
    protected $pageContentModel;
    protected $pageModel;
    protected $contentModel;

    public function __construct()
    {
        // inisialisasi
        $this->articleModel     = new ArticleModel();
        $this->contentModel     = new ContentModel();
        $this->pageModel        = new PageModel();
        $this->pageContentModel = new PageContentModel();        
    }

    public function index(): string
    {
        helper('text');
        $data['title']        = 'Home';
        $data['articles']     = $this->articleModel->getLatest();
        $data['about']        = $this->pageContentModel->getPageContentByTitle('About Us');    
        // dd($data['about']);
        
        foreach ($data['articles'] as &$article) {
            $article['image'] = base64_encode($article['image']);
        }
        return view('home', $data);
    }

    public function pages($slug)
    {
        helper('text');
        $data['page']      = $this->pageModel->getBySlug($slug);
        $data['contents']  = $this->contentModel->getContentByPages($slug);
        $data['articles']  = $this->articleModel->getAll();
        $data['slug']      = $slug;
        return view('pages', $data);
    }
}
