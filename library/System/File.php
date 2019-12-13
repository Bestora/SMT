<?php

/**
 * PHP SMT by palle
 * Monitor your servers and websites.
 *
 * This file is part of PHP SMT by palle.
 * PHP SMT by palle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP SMT by palle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP SMT by palle.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     SMT
 * @author      Werner Pallentin <werner.pallentin@outlook.de>
 * @copyright   Copyright (c) Werner Pallentin <werner.pallentin@outlook.de>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v2.1
 * @link        http://palle.zapto.org/
 **/

class File
{

  public $DIR_ROOT = project_path;
  public $CONTROLLER = 'controller';
  public $TEMPLATE = 'template';
  public $CONTENT = 'content';
  public $UPLOAD = 'assets/uploads/';


  public function getAttachment($controller, $id)
  {
    $error = False;
    $db = new Database('SMT-ADMIN');
    $db->getQuery("SELECT * FROM wos_attachments WHERE controller=:controller && identkey=:identkey", array(':controller' => $controller, ':identkey' => $id), False);
    $value = $db->getValue();

    for ($i = 0; $i < count($value); $i++) {
      if (!file_exists($this->UPLOAD . $value[$i]['attachment'])) {
        unset($value[$i]);
      }
    }

    return $value;
  }

  /**
   * Metohde zum auslesen eines Verzeichnisses
   *
   * @param <string> $sFolder
   * @return boolean
   */
  public function readDir($sFolder)
  {
    $i = 1;
    $o = 1;
    $files = array();

    $ordner = opendir($this->getDir() . $sFolder);
    while ($liste = readdir($ordner)) {
      if (!strstr($liste, '.')) {
        $files ["ordner"] [$i] ["name"] = $liste;
        $files ["ordner"] [$i] ["date"] = date("d.m.Y", filemtime($this->getDir() . '' . $sFolder . '/' . $files ["ordner"] [$i] ['name']));
        $files ["ordner"] [$i] ["time"] = date("H:i:s", filemtime($this->getDir() . '' . $sFolder . '/' . $files ["ordner"] [$i] ['name']));

        if (is_writable($this->getDir() . '' . $sFolder . '/' . $files ["ordner"] [$i] ['name'])) {
          $files ["ordner"] [$i] ["writeable"] = true;
        } else {
          $files ["ordner"] [$i] ["writeable"] = false;
        }
        $i++;
      }

      if (strstr($liste, '.') && substr($liste, 0, 1) != '.') {
        $files ["dateien"] [$o] ["name"] = $liste;
        $files ["dateien"] [$o] ["datum"] = date("d.m.Y", filemtime($this->getDir() . '' . $sFolder . '/' . $files ['dateien'] [$o] ['name']));
        $files ["dateien"] [$o] ["zeit"] = date("H:i:s", filemtime($this->getDir() . '' . $sFolder . '/' . $files ['dateien'] [$o] ['name']));
        $files ["dateien"] [$o] ["size"] = round((filesize($this->getDir() . '' . $sFolder . '/' . $files ['dateien'] [$o] ['name']) / 1024), 2);

        if (is_writable($this->getDir() . '' . $sFolder . '/' . $files ['dateien'] [$o] ['name'])) {
          $files ["dateien"] [$o] ["image"] = 'check';
          $files ["dateien"] [$o] ["write"] = true;
        } else {
          $files ["dateien"] [$o] ["image"] = 'fail';
          $files ["dateien"] [$o] ["write"] = false;
        }
        $o++;
      }
    }
    return $files;
  }

  /**
   * Methode zum ermitteln von Dateidetails
   *
   * @param <string> $path
   * @param <string> $size
   * @return <string>
   */
  function get_size($path, $size)
  {
    $measure = "Byte";

    if (!is_dir($path)) {
      $size += filesize($path);
    } else {
      $dir = opendir($path);
      while ($file = readdir($dir)) {
        if (is_file($path . "/" . $file)) {
          $size += filesize($path . "/" . $file);
        }
        if (is_dir($path . "/" . $file) && $file != "." && $file != "..") {
          $size = $this->get_size($path . "/" . $file, $size);
        }
      }
    }

    if ($size >= 1024) {
      $measure = "KB";
      $size = $size / 1024;
    }
    if ($size >= 1024) {
      $measure = "MB";
      $size = $size / 1024;
    }
    if ($size >= 1024) {
      $measure = "GB";
      $size = $size / 1024;
    }

    $size = sprintf("%01.2f", $size);
    $size = $size . " " . $measure;

    return ($size);
  }

  /**
   * Verschienden Rückgabefunktionen für die vereinfachte Handhabung der Ordnerstruktur
   */
  public function getControllerDir()
  {
    return '/' . $this->CONTROLLER;
  }

  public function getControllerPath()
  {
    return $this->CONTROLLER;
  }

  public function getTemplateDir()
  {
    return $this->DIR_ROOT . $this->TEMPLATE;
  }

  public function getTemplatePath()
  {
    return $this->TEMPLATE;
  }

  public function getContentDir()
  {
    return $this->getTemplateDir() . '/' . $this->CONTENT;
  }

  public function getContentPath()
  {
    return $this->getTemplatePath() . '/' . $this->CONTENT;
  }

  public function getDir()
  {
    return $this->DIR_ROOT;
  }

  public function uploadFile($controller, $files, $id = '')
  {
    $db = new Database('SMT-ADMIN');
    $anzahl = count($files['name']);
    $return = '';

    for ($i = 0; $i < $anzahl; $i++) {
      $tmp = $files["tmp_name"][$i];

      if (!empty($files["name"][$i])) {
        $name = basename($files["name"][$i]);
        $name = rand() . '-' . $name;
        $name = str_replace(" ", "", $name);

        move_uploaded_file($tmp, $this->UPLOAD . $name);
        $db->getQuery("INSERT INTO wos_attachments (controller, identkey, attachment) VALUE (:controller, :identkey, :attachment)",
          array(':controller' => $controller, ':identkey' => $id, ':attachment' => $name), False);

        /**
         * Aus dem PDF File ein neues mit reinen Text Elementen anlegen
         * und anschließend als TXT Datei den Content speichern
         */
        if($files['type'][$i] == 'application/pdf') {
          $ssh = new SSH('localhost');
          $ssh->cmdExec('ocrmypdf -l deu+eng '.project_path.'/'.$this->UPLOAD . $name .' '.project_path.'/'.$this->UPLOAD . 'OCR_' .$name);
          $ssh->cmdExec('pdftotext '.project_path.'/'.$this->UPLOAD . 'OCR_' . $name .' '.project_path.'/'. $this->UPLOAD . $name .'.txt');

          $db->getQuery("UPDATE wos_attachments SET contenttext=:contenttext WHERE id=:id",
            array(':contenttext' => file_get_contents($this->UPLOAD . $name .'.txt'), ':id' => $db->getLastID() ) );

          unlink($this->UPLOAD . 'OCR_' .$name);
          unlink($this->UPLOAD . $name .'.txt');
        }

        $return .= $name . ',';
      }
    }

    return substr($return, 0, -1);
  }

  public function downloadFile($file)
  {
    $name = $file;
    $file = $this->UPLOAD . $file;
    header('HTTP/1.1 200 OK');
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $name . ';');
    header('Content-Length: ' . filesize($file));

    readfile($file);
  }

  public function deleteFile($file) {
    $db = new Database('SMT-ADMIN');

    unlink($this->UPLOAD . $file);
    $db->getQuery("DELETE FROM wos_attachments WHERE attachment=:attachment", array(':attachment' => $file) );
  }

}

?>
