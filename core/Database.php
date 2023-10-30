<?php

class Database
{
    private $host = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $database = DB_NAME;

    private $conn;

    // Constructor para la conexión
    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $this->conn->connect_error);
        }
    }

    // Función para ejecutar consultas
    public function dbQuery($sql)
    {
        return $this->conn->query($sql);
    }

    // Función para ejecutar consultas preparadas
    public function dbQueryPreparada($sql, $params = array())
    {
        if (count($params) > 0) {
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                if (count($params) == 1) {
                    $paramType = $this->determineParamType($params[0]);
                    $stmt->bind_param($paramType, ...$params);
                } else {
                    $paramType = '';
                    foreach ($params as $param) {
                        $paramType .= $this->determineParamType($param);
                    }
                    $stmt->bind_param($paramType, ...$params);
                }

                $stmt->execute();
                return $stmt->get_result();
            } else {
                die("Error en la preparación de la consulta: " . $this->conn->error);
            }
        } else {
            return $this->conn->query($sql);
        }
    }

    // Función para obtener un solo resultado en un array asociativo
    public function dbFetchAssoc($sql)
    {
        $result = $this->dbQuery($sql);
        return $result->fetch_assoc();
    }

    // Función para obtener múltiples resultados en un array asociativo
    public function dbFetchMultipleAssoc($sql)
    {
        $result = $this->dbQuery($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    // Función para obtener un solo resultado en un array asociativo con consulta preparada
    public function dbFetchAssocPreparada($sql, $params = array())
    {
        $result = $this->dbQueryPreparada($sql, $params);
        return $result->fetch_assoc();
    }

    // Función para obtener múltiples resultados en un array asociativo con consulta preparada
    public function dbFetchMultipleAssocPreparada($sql, $params = array())
    {
        $result = $this->dbQueryPreparada($sql, $params);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }


    // Función para escapar datos
    public function escapeData($data)
    {
        return $this->conn->real_escape_string($data);
    }

    // Cierra la conexión
    public function closeConnection()
    {
        $this->conn->close();
    }

    // Función para determinar el tipo de parámetro
    private function determineParamType($param)
    {
        if (is_int($param)) {
            return "i"; // Entero
        } elseif (is_float($param)) {
            return "d"; // Decimal
        } else {
            return "s"; // Cadena
        }
    }
}
