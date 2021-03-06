<?php



abstract class Model
{
	private $table;
	protected $db;
	private $primaryKey ="id";
	public function __construct($table)
	 {
		 $this->table = $table;
		 
		 $this->db =self::getDb();
		 
	 }
    public static function create($class){
	    require $class.'.php';
        $class_name = $class;
        return new $class_name();
    }
  static function getDb(){
     
	   // $dsn = 'mysql:dbname=guidedup_groupeHome;host=127.0.0.1';
       // $user = 'guidedup_userdb';
      // $password = 'y@}#knq#9GM{';
	  
	  $dsn = 'mysql:dbname=stock;host=127.0.0.1';
	  $user = 'root';
      $password = '';
     
		try {
			$pdo = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
		} catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
		}
       
        return $pdo;
    }
  public function find($req = null) {
		
		
       $sql="";
		
        $sql = 'SELECT ';
        if (isset($req['fields'])) {
            if (!is_array($req['fields'])) {
                $sql .= $req['fields'];
            } else {
                $sql .=implode(', ', $req['fields']);
            }
        } else {
            $sql .='*';
        }

        $sql .=' FROM ' . $this->table . ' ';


        if (isset($req['conditions'])) {
			
            if (!is_array($req['conditions'])) {
                $sql .= ' WHERE ' . $req['conditions'];
            } else {
                $cond = array();
                foreach ($req['conditions'] as $k => $v) {
                    if (is_array($v)) {
                        if(isset($v['between'])){
                            $cond[] = '`' . $k . '` between \'' . $v['between'][0] . '\' AND \'' . $v['between'][1] .'\'';
                        }elseif(isset($v['inferieur'])){
                            $cond[] = '`' . $k . '` < \'' . $v['inferieur'].'\'';
                        }elseif(isset($v['inferieurOuEgal'])){
                            $cond[] = '`' . $k . '` <= \'' . $v['inferieurOuEgal'].'\'';
                        }elseif(isset($v['superieur'])){
                            $cond[] = '`' . $k . '` > \'' . $v['superieur'].'\'';
                        }elseif(isset($v['superieurOuEgal'])){
                            $cond[] = '`' . $k . '` >= \'' . $v['superieurOuEgal'].'\'';
                        }elseif(isset($v['not'])){
                            if(is_array($v['not'])){
                                $cond[] = '`' . $k . '` not in (' . implode(array_values($v['not']), ',') . ')';
                            }else{
                                $cond[] = '`' . $k . '` <> \'' . $v['not'].'\'';
                            }
                        }elseif(isset($v['is'])){
                            $cond[] = '`' . $k . '` is ' . $v['is'];
                        }else{
                            $cond[] = '`' . $k . '` in (' . implode(array_values($v), ',') . ') ';
                        }
                    }elseif($v<>'%'){
                        if (!is_numeric($v)) {
                            $cond[] = '`' . $k . '` like ' . $this->db->quote($v);
                        } else {
                            $cond[] = "`$k`=$v";
                        }                    }
                    }
                $sql.= ( count($cond) >= 1) ? ' WHERE ' . implode(' AND ', $cond) : '';
            }
        }
        if(isset($req['groupBy'])){
            $sql .=' GROUP BY '.$req['groupBy'];
        }
        if (isset($req['orderBy'])) {
            $sql .= ' ORDER BY ' . $req['orderBy'];
        } else {
            $sql .= ' ORDER BY  id Desc ';
        }
        if (isset($req['limit'])) {
            $sql .= ' LIMIT ' . $req['limit'];
        }
        try{
       //echo $sql;
            //var_dump($sql);
            $pre = $this->db->prepare($sql);
            $pre->execute();
            return $pre->fetchAll();
        }catch(Exception $ex){
            $req = $this->db->prepare('insert into problemes (name,value) values (:name,:value)');
            $req->execute(array('name'=>'from "find" method Model','value'=>$sql.' --- '.$ex));
            return array();
        }
    }
	
	
	
		 
	 public function save(&$data) {
        $key = $this->primaryKey;
        $fields = array();
        //var_dump($data);
        foreach ($data as $k => $v) {
            if ($v!=null && $k != $key) {
                $fields[] = "`$k`=:$k";
                $d[":$k"] = "$v";
            }
        }
	 
		 
        if (!empty($data[$key])) {
            $sql = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $fields) . ' WHERE ' . $key . '=:' . $key;
            $d[$key] = $data[$key];
            $action = 'update';
        } else {
            $sql = 'INSERT INTO ' . $this->table . ' SET ' . implode(', ', $fields);
			
            $action = 'insert';
        }

        $pre = $this->db->prepare($sql);
        try {
           
        $r = $pre->execute($d);
            if ($action == 'insert') {
                $this->$key = $this->db->lastInsertId();
                //$data[$key] = $this->$key;
                return $this->$key;
               // var_dump($this->$key);
            }
            return true;
        } catch (PDOException $exc) {
            if ($exc->getCode() == '23000')
                $_SESSION['flash'] = array(
                    'message' => 'Identifiant déjà existant {'.$this->table."}",
                    'type' => 'error');

            $req = $this->db->prepare('insert into problemes (name,value) values (:name,:value)');
            $req->execute(array('name'=>'from "save" method Model','value'=>$sql.' --- '.$exc));
            return false;
        }
    }
	
    public function findFromRelation($tables, $keys, $req = null) {
		
        $sql = 'SELECT ';

        if (isset($req['fields'])) {
            if (!is_array($req['fields'])) {
                $sql .= $req['fields'];
            } else {
                $sql .=implode(', ', $req['fields']);
            }
        } else {
            $sql .='*';
        }

        $sql .=' FROM ' . $tables . ' ';
        $sql .= 'WHERE ' . $keys;

        if (isset($req['conditions'])) {
            if (!is_array($req['conditions'])) {
                $sql .= ' WHERE ' . $req['conditions'];
            } else {
                $cond = array();
                foreach ($req['conditions'] as $k => $v) {
                    if (is_array($v)) {
                        //$cond[] = $k . ' in (' . implode(array_values($v), ',') . ') ';
						if(isset($v['between'])){
                            $cond[] = $k . ' between \'' . $v['between'][0] . '\' AND \'' . $v['between'][1] .'\'';
                        }elseif(isset($v['inferieur'])){
                            $cond[] =  $k . '` < \'' . $v['inferieur'].'\'';
                        }elseif(isset($v['inferieurOuEgal'])){
                            $cond[] =  $k . '` <= \'' . $v['inferieurOuEgal'].'\'';
                        }elseif(isset($v['superieur'])){
                            $cond[] = $k . '` > \'' . $v['superieur'].'\'';
                        }elseif(isset($v['superieurOuEgal'])){
                            $cond[] = $k . '` >= \'' . $v['superieurOuEgal'].'\'';
                        }elseif(isset($v['not'])){
                            if(is_array($v['not'])){
                                $cond[] =  $k . '` not in (' . implode(array_values($v['not']), ',') . ')';
                            }else{
                                $cond[] = $k . '` <> \'' . $v['not'].'\'';
                            }
                        }elseif(isset($v['is'])){
                            $cond[] =$k . '` is ' . $v['is'];
                        }else{
                          //  $cond[] =$k . '` in (' . implode(array_values($v), ',') . ') ';
                        }
                    } elseif (!is_numeric($v)) {
                       // $cond[] = $k . ' like "' . mysql_real_escape_string($v) . '"';
						$cond[] = $k . ' like '. $this->db->quote($v) ;
						//echo mysql_real_escape_string($v);  </br>";
						
                    } else {
                        $cond[] = "$k=$v";
                    }
                }
                $sql.= ( count($cond) >= 1) ? ' AND ' . implode(' AND ', $cond) : '';
            }
        }
		
		if (isset($req['groupBy'])) {
            $sql .= ' GROUP BY ' . $req['groupBy'];
        }
        if ((isset($req['orderBy'])))  {
            $sql .= ' ORDER BY ' . $req['orderBy'];
        }
	
        if (isset($req['limit'])) {
            $sql .= ' LIMIT ' . $req['limit'];
        }
        //echo $sql;
        //debug($sql);
          //echo $sql;
        $pre = $this->db->prepare($sql);
        $pre->execute();
      return $pre->fetchAll();
    }
	
	 public function delete($id) {
        $pre = $this->db->prepare("delete from {$this->table} WHERE $this->primaryKey = $id");
		//print_r($pre);
        return $pre->execute();
    }
		 public function deleteByTable($id,$table) {
        $pre = $this->db->prepare("delete from ".$table." WHERE id = ".$id);
		//print_r($pre);
        return $pre->execute();
    }

   public  function export_excel($data,$header,$name)
    {
        $excelFile=Model::create('PHPExcel');
        $c='A';
        $r=1;
        /*
         * set header label
         */
        for($i=0;$i<count($header);$i++)
        {
            $excelFile->getActiveSheet()->SetCellValue($c.$r, "$header[$i]");

            $c++;
        }
        /*
         * set body data
         */
//        echo count($header);
         //var_dump($data);
        $r=2;
        for($i=0; $i<count($data); $i++) {
            $c='A';
            for($j=0;$j<count($header);$j++){
                $excelFile->getActiveSheet()->SetCellValue($c.$r, $data[$i][$j]);
                $c++;
            }
            $r++;
        }
        // We'll be outputting an excel file
        $excelFile->getActiveSheet()->getStyle("A1:L1")->getFont()->setBold(true);
        $excelFile->getActiveSheet()->getStyle("A1:L1") ->getFill()->getStartColor()->setRGB('F28A8C');
        $excelFile->setActiveSheetIndex(0);
        header('Content-type: application/vnd.ms-excel');
        // It will be called file.xls
        header('Content-Disposition: attachment; filename="'.$name.'.xls"');
        $objWriter = PHPExcel_IOFactory::createWriter($excelFile, 'Excel5');
        $objWriter->save('php://output');
       die();
    }

}
