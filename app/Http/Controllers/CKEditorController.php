<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class CKEditorController extends Controller
{
    //
    protected function checkDir($uploadDir, $year, $month){
        if (!file_exists($uploadDir.$year)) {
            mkdir($uploadDir.$year, 0777, true);
        }
        if (!file_exists($uploadDir.$year.'/'.$month)) {
            mkdir($uploadDir.$year.'/'.$month, 0777, true);
        }
    }
    public function uploadImg(){
        try {
            if (isset($_FILES['upload'])) {
                $errors = [];
                $fileExtensions = ['jpeg','jpg','png','gif','svg'];
                $uploadDirectory = public_path() . "\ckeditor\uploads" . DIRECTORY_SEPARATOR;

                $imgType = explode('/', $_FILES['upload']['type'])[1];
                $tmp_name = $_FILES['upload']['tmp_name'];
                $name = basename($_FILES['upload']['name']);
                $size = $_FILES['upload']['size'];

                $year = date("Y");
                $month = date("m");
                if (in_array($imgType, $fileExtensions)) {
                    if($size <= 2000000) {
                        self::checkDir($uploadDirectory, $year, $month);

                        $newName = uniqid() . '.' . $imgType;
                        $uploadDirectory .= $year.'/'.$month.'/';
                        move_uploaded_file($tmp_name, $uploadDirectory . '/' . $newName);
                    } else {
                        $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
                    }
                } else {
                    $errors[] = "This file extension is not allowed. Please upload a JPEG ,svg,gif,jpg,PNG file";
                }
                if(empty($errors)) {
                    $response = [
                        'uploaded' => true,
                        'url' => 'http://myvision.loc/public/ckeditor/uploads/'.$year.'/'.$month.'/'.$newName
                    ];
                    return json_encode($response);
                } else {
                    $response = [
                        'uploaded' => false,
                        'error' => [
                            'message' => 'could not upload this image.',
                        ]
                    ];
                    return json_encode($response);
                }
            } else {
                $response = [
                    'uploaded' => false,
                    'error' => [
                        'message' => 'could not upload this image.',
                    ]
                ];
                return json_encode($response);
            }
        } catch (\Exception $e){
            $response = [
                'uploaded' => false,
                'error' => [
                    'message' => 'could not upload this image.',
                ]
            ];
            return json_encode($response);
        }
    }
}
