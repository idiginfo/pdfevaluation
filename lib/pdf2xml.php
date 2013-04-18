<?php
class pdf2xml
{
    private $file = null;
    
    private $filename = null;
    
    private $output = null;
    
    private $_rootDir = null;
    
    private $_xmlDir = null;
    
    public function __construct()
    {
        $this->_rootDir = rDirName(__FILE__, 3);
        $this->_xmlDir = $this->_rootDir . '/storage/xml_in/';
    }
    
    public function exec()
    {
        $xmlDir = dir($this->_xmlDir);

        $regex = '%^(.+).pdf$%';

        $dirList = array();
        
        
        try
        {
            while (false !== ($entry = $xmlDir->read()))
            {
                if(preg_match($regex, $entry))
                {                    
                    $dirList[] = $entry;
                }
            }
            $xmlDir->close();
            d($dirList);
            
            $count = array();
            
            for($i = 0; $i < sizeof($dirList); $i++)
            {
                $file_in['pdfx'] = $this->_xmlDir . $dirList[$i] . '_pdfx.xml';
                $file_in['pdfextract'] = $this->_xmlDir . $dirList[$i] . '_pdfextract.xml';
                $file_in['scholar2text'] = $this->_xmlDir . $dirList[$i] . '_scholar2text.txt';
                
                $xmlstr_pdfx = file_get_contents($file_in['pdfx']);
                $xmlcont_pdfx = new SimpleXMLElement($xmlstr_pdfx);

                $xmlstr_pdfextract = file_get_contents($file_in['pdfextract']);
                $xmlcont_pdfextract = new SimpleXMLElement($xmlstr_pdfextract);

                $ref_list = 'ref-list';


                $references_pdfx = $xmlcont_pdfx->article->body->section[4]->$ref_list;
                $references_pdfextract = $xmlcont_pdfextract;

                d($references_pdfx->children());
                d($references_pdfextract->children());
                
                $count[$i]['filename'] = $dirList[$i];
                $count[$i]['pdfx'] = sizeof($references_pdfx->children());
                $count[$i]['pdfextract'] = sizeof($references_pdfextract->children());
            }
            
            return $count;
            

            //
            //XML processing mumbo jumbo goes here!
            //

            //fclose($handle);
        }
        catch(Exception $err)
        {
            die('<p>FATAL ERROR thrown while attempting to open/close a file.</p><p>' . $err . '</p>');
        }
        
        /*
        try
        {
            foreach($file_in as $f)
            {
                $handle = fopen($f, 'r');

                //
                //XML processing mumbo jumbo goes here!
                //

                fclose($handle);
            }
        }
        catch(Exception $err)
        {
            die('<p>FATAL ERROR thrown while attempting to open/close a file.</p><p>' . $err . '</p>');
        }
         */
    }
    
}

//Recursive Directory Function.  This takes two arguments: the name of the file, which is most commonly going to be __FILE__, and how far up the directory tree you want to go.  put in 0 if you just want the directory the current file is in.  1 to go up one, 2 to go up two, and so on.
//This returns the directory structure however many levels up you request.  This is currently used primarily for including Non-Zend Framework files.
function rDirName($file, $x)
{
	if ($x >= 0)
	{
		return rDirName(dirname($file), $x-1);
		//return $dirName;
	}
	else
	{
		return $file;
	}
}
?>
