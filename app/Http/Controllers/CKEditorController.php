<?php

namespace App\Http\Controllers;

use App\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use PhpParser\Node\Expr\Cast\Object_;

class CKEditorController extends Controller
{
    //
    public function bytesToMb($bytes){
        $mb = $bytes / 1024 / 1024;
        return ($mb > 0) ? $mb : 0;
    }

    /**
     * @param String $uploadDir
     * @param int $year
     * @param int $month
     */
    protected function checkDir($uploadDir, $year, $month){
        if (!file_exists($uploadDir.$year)) {
            mkdir($uploadDir.$year, 0777, true);
        }
        if (!file_exists($uploadDir.$year.'/'.$month)) {
            mkdir($uploadDir.$year.'/'.$month, 0777, true);
        }
    }

    /**
     * @param $file
     * @param $maxSizeInMb
     * @return bool
     * @throws Exception
     */
    protected function checkSize($file, $maxSizeInMb){
        $mb = self::bytesToMb($file['size']);
        if ($mb > $maxSizeInMb) {
            throw new Exception("This file is more than $maxSizeInMb MB. Sorry, it has to be less than or equal to $maxSizeInMb MB.");
        }
        return true;
    }

    /**
     * @param $file
     * @param array $allowedExtensions
     * @return bool
     * @throws Exception
     */
    protected function checkExtension($file, array $allowedExtensions){
        $imgType = explode('/', $file['type'])[1];
        if (!in_array($imgType, $allowedExtensions)) {
            throw new Exception("This file extension is not allowed. Please upload a ". implode(', ', $allowedExtensions) ." file.");
        }
        return true;
    }

    public function uploadImg(){
        try {
            if (isset($_FILES['upload'])) {
                self::checkExtension($_FILES['upload'], ['jpeg', 'jpg', 'png', 'gif', 'svg', 'bmp']);
                self::checkSize($_FILES['upload'], 2);

                $uploadDirectory = public_path() . DIRECTORY_SEPARATOR . "ckeditor" . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $year = date("Y");
                $month = date("m");
                self::checkDir($uploadDirectory, $year, $month);

                $imgType = explode('/', $_FILES['upload']['type'])[1];
                $tmp_name = $_FILES['upload']['tmp_name'];

                $newName = uniqid() . '.' . $imgType;
                $uploadDirectory .= $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR;

                move_uploaded_file($tmp_name, $uploadDirectory . '/' . $newName);

                $response = [
                    'uploaded' => true,
                    'url' => URL::to('/') . '/public/ckeditor/uploads/'.$year.'/'.$month.'/'.$newName
                ];
                return json_encode($response);
            } else {
                throw new Exception("Something went wrong...");
            }
        } catch (\Exception $e){
            $response = [
                'uploaded' => false,
                'error' => [
                    'message' => $e->getMessage(),
                ]
            ];
            return json_encode($response);
        }
    }
}
