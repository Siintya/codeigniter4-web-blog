public function updateMedia($id) 
{
    // Set rules untuk gambar
    $this->validation->setRules([
        'image' => [
            'rules'  => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'uploaded' => 'Please upload an image.',
                'max_size' => 'The image size must not exceed 1 MB.',
                'is_image' => 'Please upload a valid image file.',
                'mime_in'  => 'Only .jpg, .jpeg, and .png files are allowed.',
            ]
        ]
    ]);

    // Validasi input
    if (!$this->validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
    }

    if ($this->request->getPost()) {
        // Ambil data input captions
        $captions = $this->request->getPost('captions');
        $updated_at = $this->request->getPost('updated_at');

        // Ambil data file jika ada
        $file = $this->request->getFile('image');
        $isNewFile = $file->isValid() && !$file->hasMoved();

        // Data untuk update captions saja
        $data = [
            'captions'   => $captions,
            'updated_at' => $updated_at
        ];

        // Jika file baru di-upload dan berbeda dari sebelumnya, tambahkan data file
        if ($isNewFile) {
            $imageFile = file_get_contents($file->getTempName());
            $data['filename'] = $file->getClientName();
            $data['filetype'] = $file->getClientMimeType();
            $data['image'] = $imageFile;
        }

        // Cek apakah media dengan id sudah ada
        $existingMedia = $this->articleMediaModel->find($id);

        if ($existingMedia) {
            // Lakukan update
            $updated = $this->articleMediaModel->update($id, $data);
            if ($updated) {
                return redirect()->to('articles/update/' . $id . '#articleMedia')->with('success-media', 'Image has been updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to update image');
            }
        } else {
            // Lakukan insert baru
            $inserted = $this->articleMediaModel->insert($data);
            if ($inserted) {
                return redirect()->to('articles/update/' . $id . '#articleMedia')->with('success-media', 'Image has been inserted successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to insert image');
            }
        }
    }
}
