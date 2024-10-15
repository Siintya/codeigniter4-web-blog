<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Controller;
use App\Libraries\DataTables;
use Hermawan\DataTables\DataTable;
use App\Models\ArticleModel;
use App\Models\ArticleMediaModel;
use App\Models\UserModel;
use App\Models\TagModel;
use App\Models\CategoryModel;
use App\Models\ContentModel;
use App\Models\PageModel;
use App\Models\PageContentModel;
use DateTime;

class Content extends BaseController
{
    protected $validation;
    protected $articleModel;
    protected $articleMediaModel;
    protected $userModel;
    protected $tagModel;
    protected $categoryModel;
    protected $contentModel;
    protected $pageModel;
    protected $pageContentModel;

    public function __construct()
    {
        $this->validation           = \Config\Services::validation();

        $this->articleModel         = new ArticleModel();
        $this->articleMediaModel    = new ArticleMediaModel();
        $this->userModel            = new UserModel();
        $this->tagModel             = new TagModel();
        $this->categoryModel        = new CategoryModel();
        $this->contentModel         = new ContentModel();
        $this->pageModel            = new PageModel();
        $this->pageContentModel     = new PageContentModel();
    }

    public function store($id)
    {
        // Set rules
        $this->validation->setRules([
            'image'      => [
                'rules'  => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Please upload an image.',
                    'max_size' => 'The image size must not exceed 1 MB.',
                    'is_image' => 'Please upload a valid image file.',
                    'mime_in'  => 'Only .jpg, .jpeg, and .png files are allowed.',
                ],
            ]
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error_modal', 'add_' . $id);
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        if ($this->request->getPost()) {
            $file = $this->request->getFile('image');
            $imageFile = file_get_contents($file->getTempName());

            $data = [
                'title'      => $this->request->getPost('title'),
                'slug'       => $this->request->getPost('slug'),
                'content'    => $this->request->getPost('content'),
                'image'      => $imageFile,
                'created_at' => $this->request->getPost('created_at'),
                'updated_at' => null,
            ];
            // dd($data);
            $created = $this->contentModel->create($data); 
            if ($created) {
                $dataPageContent = [
                    'pages_id'    => $id,
                    'contents_id' => $this->contentModel->insertID(),
                    'created_at'  => $this->request->getPost('created_at'),
                    'updated_at'  => null,
                ];
                // dd($dataPageContent);
                $save = $this->pageContentModel->create($dataPageContent); // use insert instead of create
                if ($save) {
                    return redirect()->to('pages/update/' . $id . '#pagesContents')->with('success', 'The content section saved successfully');
                }
            } else {
                return redirect()->to('pages/update/' . $id . '#pagesContents')->with('error', 'Failed to save content section');
            }
        }
    }

    public function update($id)
    {
        // Set rules untuk validasi
        $this->validation->setRules([
            'image'      => [
                'rules'  => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'The image size must not exceed 1 MB.',
                    'is_image' => 'Please upload a valid image file.',
                    'mime_in'  => 'Only .jpg, .jpeg, and .png files are allowed.',
                ],
            ]
        ]);
        // Validasi input
        if (!$this->validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error_modal', 'update_' . $id);
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }
        $currentData = $this->contentModel->getById($id);
        $pagesId     = $this->request->getPost('pages_id');
    
        if ($this->request->getPost()) {
            $imageFile = $this->request->getFile('image');
            $imageData = null;
            // Cek apakah file gambar valid
            if ($imageFile && $imageFile->isValid() && $imageFile->getSize() > 0) {
                $imageData = file_get_contents($imageFile->getTempName());
            } else {
                // Jika tidak ada perubahan gambar, gunakan gambar yang ada
                $imageData = $currentData['image'];
            }
            // Data baru yang akan diupdate
            $newData = [
                'title'   => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'slug'    => $this->request->getPost('slug'),
                'image'   => $imageData
            ];
            // Cek apakah ada perubahan data
            $isChanged = false;
            foreach ($newData as $key => $value) {
                if ($currentData[$key] != $value) {
                    $isChanged = true;
                    break;
                }
            }
            // Jika tidak ada perubahan, kembalikan pesan info
            if (!$isChanged) {
                return redirect()->back()->with('info', 'No changes were made.');
            }
    
            // Lakukan update data
            $newData['updated_at'] = $this->request->getPost('updated_at');
            $updated = $this->contentModel->updated($id, $newData);
            if ($updated) {
                return redirect()->to('pages/update/' . $pagesId . '#pagesContents')->with('success', 'The content section updated successfully!');
            } else {
                return redirect()->to('pages/update/' . $pagesId . '#pagesContents')->withInput()->with('error', 'Failed to update content section');
            }
        }
    }
    
    public function delete($id)
    {
        $pagesId = $this->pageContentModel->getByContents($id);
        $deleted = $this->contentModel->deleted($id);

        if ($deleted) {
            if ($pagesId !== null && isset($pagesId['pages_id'])) {
                return redirect()->to('pages/update/' . $pagesId['pages_id'] . '#pagesContents')
                                ->with('success', 'The content section deleted successfully!');
            } else {
                return redirect()->to('pages/update')->with('error', 'Failed to get pages id.');
            }
        } else {
            return redirect()->to('pages/update')->with('error', 'Failed to delete content section');
        }
    }

}
