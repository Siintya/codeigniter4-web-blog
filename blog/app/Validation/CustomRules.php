<?php 
namespace App\Validation;

use App\Models\PageModel;

class CustomRules
{
    public function is_unique_title_except_current(string $str, string $fields, array $data): bool
    {
        $id = $fields;
        $pageModel = new PageModel();
        return $pageModel->is_unique_title_except_current($str, $id);
    }
}
