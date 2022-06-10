<?php
    #RECUPERATION DES ARGUMENTS
    $arguments = getopt("s:q:");
    #var_dump($arguments);
    if (sizeof($arguments) == 2){

        #RECUPERATION DES ARGUMENTS DANS DIFFERENTES VARIABLES
        $source = $arguments["s"]; #FICHIER SOURCE
        $quality = $arguments["q"]; #NIVEAU D'OPTIMISATION

        #VERIFICATION DES ARGUMENTS
        if (!is_file($source)){
            echo "\n";
            exit("Aucun fichier de ce nom.\n");
        }
        if (is_numeric($quality)){
            $quality_ = intval($quality);
            if ($quality_ < 0 || $quality_ > 9){
                echo "\n";
                exit("Le paramètre -q doit être compris entre 0 et 9\n");
            }
        }else{
            echo "\n";
            exit("Paramètre -q non valide.\n");
        }

        #VERIFICATION DE L'EXTENSION DU FICHIER SOURCE
        $file = explode(".", $source);
        $extension = end($file); #RECUPERATION DE L'EXTENTION
        $allowTypes = array('jpg','png','jpeg');
        if(in_array($extension, $allowTypes)) {
            switch ($extension){
                case 'jpeg':
                case 'jpg':
                    $image = imagecreatefromjpeg($source);
                    break;
                case 'png':
                    $image = imagecreatefrompng($source);
                    break;
                default:
                    $image = imagecreatefromjpeg($source);
            }
            #ECRITURE DU NOUVEAU NOM DU FICHIER
            $nouveauFichier = $file[0]."-optimized-".date('dmYHis').".".end($file);

            imagepalettetotruecolor($image);
            imagewebp($image, $nouveauFichier, $quality_);
            imagedestroy($image);
            if(file_exists($nouveauFichier)){
                echo "\n";
                echo "Fichier optimisé: ".$nouveauFichier."\n";
            }else{
                echo "\n";
                exit("Une erreur est survenue.\n");
            }

        }else{
            echo "\n";
            exit("Fichier source non valide.\n");
        }
    }else{
        echo "\n";
        echo "WZ-OPTIMIZER\n";
        echo " Utilisation: php wz-optimizer.php -s chemin/vers/le/fichier -q qualite\n";
    }