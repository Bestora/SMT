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

class Database
{

  public $aValue;
  public $iNumrows;
  public $iId;
  public $error;
  protected $last;

  public function __construct($database)
  {
    $this->set('DB', parse_ini_file(project_path . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $_SERVER['SERVER_NAME'] . '.ini', TRUE));
    $this->set('DB', $this->DB[$database]);
  }

  public function set($sName, $sValue)
  {
    $this->$sName = $sValue;
  }

  public function get($sName)
  {
    if (property_exists($this, $sName)) {
      return $this->$sName;
    } else {
      return NULL;
    }
  }

  /**
   * Methode zum ausführen einer MySql Query
   *
   * @param string $query
   * @param bool $return
   */
  public function getQuery($query, $value = '', $return = FALSE, $blaetter = False)
  {
    try {
      $data = $this->get('DB');

      $DB = new PDO('mysql:host=' . $data ['db_host'] . ';dbname=' . $data ['db_base'], $data ['db_user'], $data ['db_pass']);
      $DB->exec("set names " . $data ['db_charset']);

      $q = $DB->prepare($query);
      $q->execute($value);

      if (preg_match("/select/i", $query)) {
        $this->value($q);
        $this->count($q);
      }

      if (preg_match("/insert/i", $query)) {
        $this->set('iId', $DB->lastInsertId());
      }

      if ($return === TRUE) {
        return $this->aValue;
      }

      $DB = NULL;
    } catch (Exception $e) {
      $this->set('error', $e);
      $error = new SMTError('DB_Error.log', $e);
      return $e;
    }
  }

  /**
   * Methode zum auslesen der Ergebnisse
   *
   * @param string $sName
   * @param int $iPosition
   * @return string oder array
   */
  public function getValue($sName = '', $iPosition = '')
  {
    if ($sName == '') {
      return $this->aValue;
    }

    if (!empty($sName)) {
      if ($iPosition != '') {
        return $this->aValue[$iPosition][$sName];
      } else {
        return $this->aValue['0'][$sName];
      }
    }
  }

  /**
   * Methode welche die Anzahl der Ergebnisse zurückgibt
   *
   * @return type
   */
  public function getNumrows()
  {
    return $this->get('iNumrows');
  }

  public function getLastID()
  {
    return $this->get('iId');
  }

  public function getError()
  {
    return $this->get('error');
  }

  /**
   * Eine SQL Datei in die DB importieren
   */
  public function importSQL($sqlfile)
  {
    $data = $this->get('DB');

    // Datenbank vorbereiten
    $DB = new PDO('mysql:host=' . $data ['db_host'] . ';dbname=' . $data ['db_base'], $data ['db_user'], $data ['db_pass']);
    $DB->exec("set names " . $data ['db_charset']);

    // MySql Query vorbereiten
    $queries = $this->getQueriesFromSQLFile($sqlfile);

    foreach ($queries as $query) {
      try {
        $DB->exec($query);
      } catch (Exception $e) {
        echo $e->getMessage() . "<br /> <p>Die Query ist: $query</p>";
      }
    }

    return true;
  }

  /**
   * Methode zum parsen eines SQL Datei
   */
  private function getQueriesFromSQLFile($sqlfile)
  {
    if (is_readable($sqlfile) === false) {
      throw new Exception($sqlfile . 'Datei existiert nicht oder ist nicht lesbar');
    }

    $file = file($sqlfile);
    $file = array_filter($file, create_function('$line', 'return strpos(ltrim($line), "--") !== 0;'));
    $file = array_filter($file, create_function('$line', 'return strpos(ltrim($line), "/*") !== 0;'));
    $keywords = array(
      'ALTER',
      'CREATE',
      'DELETE',
      'DROP',
      'INSERT',
      'REPLACE',
      'SELECT',
      'SET',
      'TRUNCATE',
      'UPDATE',
      'USE'
    );
    $regexp = sprintf('/\s*;\s*(?=(%s)\b)/s', implode('|', $keywords));
    $splitter = preg_split($regexp, implode("\r\n", $file));
    $splitter = array_map(create_function('$line', 'return preg_replace("/[\s;]*$/", "", $line);'), $splitter);
    $table_prefix = @$_POST ['config'] ['database'] ['prefix'];
    $splitter = preg_replace("/`your_prefix_/", "`$table_prefix", $splitter);

    return array_filter($splitter, create_function('$line', 'return !empty($line);'));
  }

  /**
   * Methode zum speichern der Ergebnisse
   *
   * @param array $q
   */
  private function value($q)
  {
    $this->set('aValue', $q->fetchAll(PDO::FETCH_ASSOC));
  }

  /**
   * Methode zum zählen der Ergebnisse
   *
   * @param type $q
   */
  private function count($q)
  {
    $this->set('iNumrows', $q->rowCount());
  }

  /**
   * Insert multiple rows into a single table
   *
   * This method is preferred  over calling the insert() lots of times
   * so it can be optimized to be inserted with 1 query.
   * It can only be used if all inserts have the same fields, records
   * that do not match the fields provided in the first record will be
   * skipped.
   *
   * @param type $table
   * @param array $data
   * @return \PDOStatement
   * @see insert()
   */
  public function insertMultiple($table, array $data)
  {
    if (empty($data))
      return false;

    $query = "INSERT INTO `{$table}` ";
    $fields = array_keys($data[0]);
    $query .= "(`" . implode('`,`', $fields) . "`) VALUES ";

    $q_part = array_fill(0, count($fields), '?');
    $q_part = "(" . implode(',', $q_part) . ")";

    $q_part = array_fill(0, count($data), $q_part);
    $query .= implode(',', $q_part);

    $con = $this->get('DB');

    $DB = new PDO('mysql:host=' . $con ['db_host'] . ';dbname=' . $con ['db_base'], $con ['db_user'], $con ['db_pass']);
    $DB->exec("set names " . $con ['db_charset']);

    $pst = $DB->prepare($query);

    $i = 1;
    foreach ($data as $row) {
      $diff_keys = array_diff_key($fields, array_keys($row));

      if (!empty($diff_keys)) {
        continue;
      }
      foreach ($fields as $field) {
        $pst->bindParam($i++, $row[$field]);
      }
    }

    try {
      $this->last = $pst->execute();
    } catch (\PDOException $e) {
      $this->error($e);
    }
    return $this->last;
  }

  /**
   * Alias to select() but uses limit = 1 to return only one row.
   * @param string $table tablename
   * @param mixed $where string or array with where data
   * @param array $fields array with fields to be retrieved. if empty all fields will be retrieved
   * @param array $orderby fields for the orderby clause
   * @param string $direction ASC or DESC. Defaults to ASC
   * @return array
   */
  public function selectRow($table, $where = null, $fields = null, $orderby = null, $direction = 'ASC')
  {
    $result = $this->getQuery($table, $where, $fields, '1', $orderby, $direction);

    if (isset($result[0])) {
      $result = $result[0];
    }

    return $result;
  }

}

?>
