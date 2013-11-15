
<?php

/*
** Function : pdf_upload
** Input : array files
** Output : none
** Description : uploads pdf files and stores them in file 'upload'
** Creator : Aurelie
** Date : 11 April 2010
*/


function pdf_upload($files, $class)
{
    foreach($files as $key=>$array)
    {
        if ($files[$key]['error'] == 0 && $key=="Pdf")
        {
            // Tests size of the file: ini php.ini the max value is 3M ie. 3145728 bytes
            if ($files[$key]['size'] <= 3145728)
            {
                // Test if the file is a pdf
                $infosfichier = pathinfo($files[$key]['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('pdf');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    $target_path='../upload/'.$class.'/'. basename($files[$key]['name']);
                    if(move_uploaded_file($files[$key]['tmp_name'], $target_path))
                    {
                        echo "File uploaded !<br>";
                    }
                    else
                    {
                        echo "There was an error uploading the file, please try again!";
                    }
                }
                else
                {
                    echo "The file you have selected is not recognized as a pdf! It has not been uploaded.";
                }
            }
            else
            {
                echo "The file you have selected is too big! It has not been uploaded.";
            }
        }
    }
}
?>
