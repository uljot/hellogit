<?php

class ListController
{
    public function listAction($request)
    {
        $list = [];

        foreach ($this->getStudentsFiles() as $file) {
            $students = simplexml_load_file($file->getPathname());
            $list = $list + $students->xpath('//student');
        }
        
        return array(
            'template' => 'list',
            'data' => $list
        );
    }

    private function endsWith($haystack, $needle) {
	    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}

    private function getStudentsFiles() 
    {
        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__ROOTDIR__.'var/'));

        $files = [];
        foreach($objects as $name => $object){
            if ($this->endsWith($name, '.xml')) {
                $files[] = $object;
            }
        }

        return $files;
    }
}
