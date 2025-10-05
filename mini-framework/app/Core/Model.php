<?php
namespace App\Core;
use App\Core\Container;


abstract class Model {
    protected $db;
    protected $table;
    // La clave primaria puede seguir siendo un solo campo por defecto,
    // pero los métodos de find, update y delete serán más flexibles.
    protected $primaryKey = "id"; 

    public function __construct() {
        $this->db = Container::get("db");
    }

    public function all() {
        $query = $this->db->query("SELECT * FROM {$this->table}");
        return $query->fetchAll(\PDO::FETCH_ASSOC); // Usamos FETCH_ASSOC para obtener un array asociativo
    }


    /**
     * Encuentra un registro por una o más condiciones.
     * Para una clave simple: ['id' => 1]
     * Para una clave compuesta: ['user_id' => 5, 'product_id' => 10]
     *
     * @param array $conditions Un array asociativo de condiciones (columna => valor).
     * @return mixed El primer registro encontrado o false si no hay ninguno.
     */
    public function find(array $conditions) {
        $whereParts = [];
        $params = [];
        foreach ($conditions as $column => $value) {
            $whereParts[] = "{$column} = ?";
            $params[] = $value;
        }

        $sql = "SELECT * FROM {$this->table} WHERE " . implode(" AND ", $whereParts) . " LIMIT 1";
        $query = $this->db->query($sql, $params);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Crea un nuevo registro.
     *
     * @param array $data Un array asociativo de datos (columna => valor).
     * @return string El ID del último registro insertado.
     */
    public function create(array $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $this->db->query($sql, array_values($data));
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Actualiza un registro por una o más condiciones.
     *
     * @param array $conditions Un array asociativo de condiciones para identificar el registro.
     * @param array $data Un array asociativo de los datos a actualizar.
     * @return \PDOStatement El objeto PDOStatement.
     */
    public function update(array $conditions, array $data) {
        $setParts = [];
        foreach (array_keys($data) as $column) {
            $setParts[] = "{$column} = ?";
        }
        
        $whereParts = [];
        $whereParams = [];
        foreach ($conditions as $column => $value) {
            $whereParts[] = "{$column} = ?";
            $whereParams[] = $value;
        }

        $sql = "UPDATE {$this->table} SET " . implode(", ", $setParts) . 
               " WHERE " . implode(" AND ", $whereParts);
        
        $params = array_merge(array_values($data), $whereParams);
        
        return $this->db->query($sql, $params);
    }
    
    /**
     * Elimina un registro por una o más condiciones.
     *
     * @param array $conditions Un array asociativo de condiciones para identificar el registro.
     * @return \PDOStatement El objeto PDOStatement.
     */
    public function delete(array $conditions) {
        $whereParts = [];
        $params = [];
        foreach ($conditions as $column => $value) {
            $whereParts[] = "{$column} = ?";
            $params[] = $value;
        }

        $sql = "DELETE FROM {$this->table} WHERE " . implode(" AND ", $whereParts);
        return $this->db->query($sql, $params);
    }

    /**
     * Ejecuta una consulta SQL cruda y devuelve el resultado.
     * Útil para consultas complejas como JOINs.
     *
     * @param string $sql La consulta SQL a ejecutar.
     * @param array $params Los parámetros para la consulta preparada.
     * @return \PDOStatement El objeto PDOStatement.
     */
    public function executeRawQuery(string $sql, array $params = []) {
		$query =  $this->db->query($sql, $params);
        return $query->fetchAll(\PDO::FETCH_ASSOC); 
    }

	public function rowCount($sql = ""){
		if ( empty($sql)){
			$sql = "SELECT count(*) nf FROM {$this->table}";
		} else {
			$sql = "SELECT count(*) nf FROM ($sql ) p";	
		}

        $query = $this->db->query($sql); 
		
        return $query->fetchAll(\PDO::FETCH_ASSOC)[0]["nf"]; 
	}

    public function allPaginado($offset= 2, $pagina = 1) {

			$pagina = ( $pagina - 1 ) * $offset;

			$sql = "SELECT *  FROM {$this->table} LIMIT $pagina,$offset ";
	        $query = $this->db->query($sql); 
		
        return $query->fetchAll(\PDO::FETCH_ASSOC); 

    }


	public function sqlPaginado( $sql = "", $pag = 1, $offset=5){

		$totalPaginas = $this->rowCount($sql);
	
		if ( empty( $sql ) ){

			$datos = $this->allPaginado($offset, $pag);

		}else{
			$pagina = ($pag -1 ) * $offset;
			$sql = "$sql  LIMIT   $pagina , $offset ";
	        $query = $this->db->query($sql); 
			$datos = 	$query->fetchAll(\PDO::FETCH_ASSOC); 
		}
		
		$totalPaginas = ceil( $totalPaginas / $offset);

		return [ "pagina" => $pag, "totalPaginas" => $totalPaginas, "datosTabla" => $datos];		
	}


}

