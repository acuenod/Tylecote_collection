
<?php

/*
** Function : photo_upload
** Input : array files
** Output : none
** Description : uploads and resizes the photo from the _FILES tables and stores them in file 'upload'
** Creator : Aurelie
** Date : 11 April 2010
*/


function photo_upload($files, $class)
{
    foreach($files as $key=>$array)
    {
            if ($files[$key]['error'] == 0 && $key!="Pdf")
            {
                    //echo"plop";
                    // Testons si le fichier n'est pas trop gros: dans php.ini valeur max est 3M ce qui est �gal � 3145728 bytes
                    if ($files[$key]['size'] <= 3145728)
                    {
                        // Testons si l'extension est autoris�e
                        $infosfichier = pathinfo($files[$key]['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'jpeg', 'JPG', 'JPEG');
                        if (in_array($extension_upload, $extensions_autorisees))
                        {
                           $ImageChoisie = imagecreatefromjpeg($files[$key]['tmp_name']);

                            $TailleImageChoisie = getimagesize($files[$key]['tmp_name']);
                            //print_r($TailleImageChoisie);
                            //if ($TailleImageChoisie[0]<=450)
                            //{
                                    imagejpeg($ImageChoisie , '../upload/'.$class.'/'.$key.'/'. basename($files[$key]['name']), 100);
                            //}
                            /*else
                            {
                                    $NouvelleLargeur = 450;
                                    $Ratio = ( ($NouvelleLargeur)/$TailleImageChoisie[0] );
                                    $NouvelleHauteur = ( ($TailleImageChoisie[1] * $Ratio) );

                                    $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");
                                    imagecopyresampled($NouvelleImage , $ImageChoisie, 0, 0, 0, 0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                                    // On peut valider le fichier et le stocker d�finitivement
                                    imagejpeg($NouvelleImage , 'upload/'.$class.'/'.$key.'/'. basename($files[$key]['name']), 100);
                            }*/
                            imagedestroy($ImageChoisie);
                            echo "Picture uploaded !<br>";
                        }
                        else
                        {
                            echo "The photo you have selected is not recognized as a picture file! It has not been uploaded.";
                        }
                    }
                    else
                    {
                        echo "The photo you have selected is too big! It has not been uploaded.";
                    }
            }
    }
}
?>