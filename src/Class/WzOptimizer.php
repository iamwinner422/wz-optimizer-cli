<?php

namespace WzOptimizer;

class WzOptimizer{
    private $s;
    private $q;
    private $ext;

    /**
     * @param $s
     * @param $q
     */
    public function __construct($s, $q)
    {
        $this->s = $s;
        $this->q = $q;
        $this->ext = null;
    }

    /**
     * @return mixed
     */
    public function getS()
    {
        return $this->s;
    }

    /**
     * @param mixed $s
     */
    public function setS($s)
    {
        $this->s = $s;
    }

    /**
     * @return mixed
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * @param mixed $q
     */
    public function setQ($q)
    {
        $this->q = $q;
    }

    /**
     * @return null
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * @param null $ext
     */
    public function setExt($ext)
    {
        $this->ext = $ext;
    }


    public function check_s(){
        if (!is_file($this->s)){
            return false;
        }else{
            return true;
        }
    }

    public function check_q_n(){
        if (is_numeric($this->q)){
            return true;
        }
        return false;
    }

    public function check_q_v(){
        $quality_ = intval($this->q);
        if ($quality_ < 0 || $quality_ > 9){
            return false;
        }else{
            return true;
        }
    }

    public function check_ext(){
        #VERIFICATION DE L'EXTENSION DU FICHIER SOURCE
        $file = explode(".", $this->s);
        $extension = end($file); #RECUPERATION DE L'EXTENTION
        $allowTypes = array('jpg','png','jpeg');
        if(in_array($extension, $allowTypes)) {
            $this->ext = $extension;
            return true;
        }else{
            return false;
        }
    }

    public function opz_(){
        switch ($this->ext){
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($this->s);
                break;
            case 'png':
                $image = imagecreatefrompng($this->s);
                break;
            default:
                $image = imagecreatefromjpeg($this->s);
        }
        #ECRITURE DU NOUVEAU NOM DU FICHIER
        $file = explode(".", $this->s);
        $nouveauFichier = $file[0]."-optimized-".date('dmYHis').".".end($file);

        imagepalettetotruecolor($image);
        imagewebp($image, $nouveauFichier, $this->q);
        imagedestroy($image);
        if(file_exists($nouveauFichier)){
            echo "\n";
            echo "Fichier optimisé: ".$nouveauFichier."\n";
            return true;
        }else{
            return false;
        }
    }
}