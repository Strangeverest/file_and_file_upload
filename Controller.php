<?php
session_start();
// controller class
class Controller
{
    // method to load view
    public function uploadFile($file)
    {
        $this->dd($file);
        $this->validateUpload($file);
    }
    // method to dump data
    public function dd($value)
    {
        echo "<pre>";

        var_dump($value);

        echo "</pre>";
    }
    // method to get file type
    public function getFileType($file, $index = 1)
    {
        $fileType = explode('/', $file);

        return $fileType[$index];
    }
    // method to get supported formats
    public function supportedFormats()
    {
        return ['jpeg', 'jpg', 'png', 'gif', 'pdf'];
    }
    // method to validate upload
    public function validateUpload($file)
    {
        $type        = $file['image']['type'];
        $tmpName     = $file['image']['tmp_name'];
        $size        = $file['image']['size'];
        $newFileName = uniqid() . '.' . $this->getFileType($type, 1);
        $fileName    = $newFileName;
        $path        = "images/" . $fileName;

        $write = fopen("uploads.txt", "a") or die("unable to open");
        fwrite($write, $fileName . "\n");
        fclose($write);

        $myfile = fopen("uploads.txt", "r") or die("Unable to open file!");
        // Output one character until end-of-file
        if (!feof($myfile)) {
            echo "<img src=\"{$path}\" style=\" width:100px; height:100px;\">";
            echo "<br>";
            echo fgets($myfile);
            echo "<br>";
        }
        fclose($myfile);

        if ($size === 0) {
            echo "Please select a file";
        } elseif ($size > 3000000000) {
            echo "File size should not be more than 2 MB";
        } elseif (!$this->getFileType($type, 0) === 'image' || !$this->getFileType($type, 0) === 'application') {
            echo "Only images are allowed";
        } elseif (!in_array($this->getFileType($type), $this->supportedFormats())) {
            echo "File type not supported";
        } else {
            move_uploaded_file($tmpName, $path);

            echo "File uploaded successfully";
        }
    }
}
session_unset()
?>
