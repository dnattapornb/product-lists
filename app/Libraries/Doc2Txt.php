<?php

namespace App\Libraries;

/**
 * this class is used to convert any doc,docx file to simple text format.
 *
 * author: Vinod Kumar
 * author's email: vinodgami1119@gmail.com
 * author's phone: +91-9589420392
 *
 * @package App\Libraries
 */
class Doc2Txt
{
    private $filename;

    public function __construct($filePath)
    {
        $this->filename = $filePath;
    }

    private function readDoc()
    {
        $fileHandle = fopen($this->filename, "r");
        $line = @fread($fileHandle, filesize($this->filename));
        $lines = explode(chr(0x0D), $line);
        $outtext = "";
        foreach ($lines as $thisline) {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== false) || (strlen($thisline) == 0)) {
            }
            else {
                $outtext .= $thisline." ";
            }
        }
        $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/", "", $outtext);

        return $outtext;
    }

    private function readDocx()
    {
        $striped_content = '';
        $content = '';

        $zip = zip_open($this->filename);

        if (!$zip || is_numeric($zip)) {
            return false;
        }

        while ($zip_entry = zip_read($zip)) {
            if (zip_entry_open($zip, $zip_entry) == false) {
                continue;
            }

            if (zip_entry_name($zip_entry) != "word/document.xml") {
                continue;
            }

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }

    public function convertToText()
    {
        if (isset($this->filename) && !file_exists($this->filename)) {
            return "File Not exists";
        }

        $fileArray = pathinfo($this->filename);
        $file_ext = $fileArray['extension'];
        if ($file_ext == "doc" || $file_ext == "docx") {
            if ($file_ext == "doc") {
                return $this->readDoc();
            }
            else {
                return $this->readDocx();
            }
        }
        else {
            return "Invalid File Type";
        }
    }
}

