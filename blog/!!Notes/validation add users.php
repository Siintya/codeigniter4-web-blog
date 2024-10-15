  // // dd($this->request->getPost());
        // $validation = \Config\Services::validation();
        // $validation->setRules([
        //     'username'   => [
        //         'rules'  => 'required|is_unique[users.username]',
        //         'errors' => [
        //             'required'  => 'Username is required.',
        //             'is_unique' => 'Username already exists.'
        //         ]
        //     ],
        //     'fullname'   => [
        //         'rules'  => 'required',
        //         'errors' => ['required' => 'Fullname is required.']
        //     ],
        //     'email'      => [
        //         'rules'  => 'required|valid_email',
        //         'errors' => [
        //             'required'      => 'Email is required.',
        //             'valid_email'   => 'Email must be a valid email address.'
        //         ]
        //     ],
        //     'no_telp'   => [
        //         'rules'  => 'required',
        //         'errors' => ['required' => 'No.Telpon is required.']
        //     ],
        //     'address'    =>  [
        //         'rules'  => 'required',
        //         'errors' => ['required' => 'Address is required.']
        //     ],
        // ]);
        // if (!$validation->withRequest($this->request)->run()) {
        //     return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        // }