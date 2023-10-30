<?php

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $params = array($id);
            return $this->db->dbFetchAssocPreparada($sql, $params);
    }

    public function obtenerTodosLosUsuarios() {
        $sql = "SELECT * FROM usuarios WHERE activo = 1";
        return $this->db->dbFetchMultipleAssoc($sql);
    }
}
