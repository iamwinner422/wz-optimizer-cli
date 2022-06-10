<?php

namespace WzOptimizer;
require_once 'src/Class/WzOptimizer.php';
class CWzOptimizer{
    public function run(){
        #RECUPERATION DES ARGUMENTS
        $arguments = getopt("s:q:");

        if (sizeof($arguments) == 2){

            $opz = new WzOptimizer($arguments["s"], $arguments["q"]);

            if ($opz->check_s()){
                if ($opz->check_q_n()){
                    if ($opz->check_q_v()){
                        if ($opz->check_ext()){
                            if (!$opz->opz_()){
                                echo "\n";
                                exit("Une erreur est survenue.\n");
                            }
                        }else{
                            echo "\n";
                            exit("Fichier source non valide.\n");
                        }
                    }else{
                        echo "\n";
                        exit("Le paramètre -q doit être compris entre 0 et 9\n");
                    }
                }else{
                    echo "\n";
                    exit("Paramètre -q non valide.\n");
                }
            }else{
                echo "\n";
                exit("Aucun fichier de ce nom.\n");
            }

        }else{
            echo "\n";
            echo "WZ-OPTIMIZER\n";
            echo " Utilisation: php main.php -s chemin/vers/le/fichier -q qualite\n";
        }
    }
}