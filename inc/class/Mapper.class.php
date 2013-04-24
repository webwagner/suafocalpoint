<?php

/**
 * Classe de CRUDS
 *
 * @author Wagner
 */
class Mapper {

    private $_dbTable;
    private $_where;
    private $_inicial;
    private $_numreg;
    private $_order;

    /**
     * Método contrutor da classe
     */
    function __construct() {
        $this->_where = 1;
        $this->_order = "id DESC";
    }

    /**
     * Cria uma instância da Zend Db
     * @access public
     * @param string $table
     */
    public function setDbTable($table) {
        if (null === $this->_dbTable) {
            $this->_dbTable = $table;
        }
    }

    /**
     * Seta o valor inicial para o limit
     * @access public
     * @param int $inicial
     */
    public function setInicial($inicial) {
        return $this->_inicial = $inicial;
    }

    /**
     * Seta o número de registros
     * @access public
     * @param int $numreg
     */
    public function setNumreg($numreg) {
        return $this->_numreg = $numreg;
    }

    /**
     * Seta o valor do where
     * @access public
     * @param string $where
     */
    public function setWhere($where) {
        return $this->_where = $where;
    }

    /**
     * Seta a ordem
     * @access public
     * @param string $order
     */
    public function setOrder($order) {
        return $this->_order = $order;
    }

    /**
     * Retorna todos os registros da tabela
     * @access public
     * @return array $result
     */
    public function getRows() {
        try {
            $where = $this->_dbTable->select()->where($this->_where)->limit($this->_numreg, $this->_inicial)->order($this->_order);
            $resultSet = $this->_dbTable->fetchAll($where);
            $result = array();
          
            foreach ($resultSet as $row) {
                $result[] = $row;
            }
            
            return $result;
        } catch (Exception $e) {
            $log = new Logger('Classe Mapper - Metodo GetRows ', "Query: {$where} \n {$e->getMessage()} \n linha: {$e->getLine()} \n arquivo: {$e->getFile()}");
            $log->createLog('log');
        }
    }

    /**
     * Retorna um registro da tabela
     * @access public
     * @return array $result
     */
    public function getRow() {
        try {
            $result = $this->_dbTable->fetchRow($this->_dbTable->select()->where($this->_where)->order($this->_order));
            return $result;
        } catch (Exception $e) {
            $log = new Logger('Classe Mapper - Metodo GetRow ', "Query: {$this->_dbTable->select()->where($this->_where)->order($this->_order)} \n {$e->getMessage()} \n linha: {$e->getLine()} \n arquivo: {$e->getFile()}");
            $log->createLog('log');
        }
    }

    /**
     * Insere ou atualiza a tabela
     * se inserir retorna o id se atualizar retorna a quantidade de linhas alteradas
     * @access public
     * @param object $classe
     * @return int
     */
    public function saveOrUpdate(Array $data) {
        try {
            $dados = self::getColunas($data);

            if (!isset($dados['id'])) {
                $id = $this->_dbTable->insert($dados);
                return $id;
            } else {
                $quant = $this->_dbTable->update($dados, array('id = ?' => $dados['id']));
                return $quant;
            }
        } catch (Exception $e) {
            $log = new Logger('Classe Mapper - Metodo saveOrUpdate ', "{$e->getMessage()} \n linha: {$e->getLine()} \n arquivo: {$e->getFile()}");
            $log->createLog('log');
        }
    }

    /**
     * Metodo que coloca apenas os dados referentes a tabela do bando de dados
     * @param array $dados os dados a serem verificados
     * @return array
     * */
    protected function getColunas(Array $dados) {
        $ret = array();

        foreach ($dados as $coluna => $valor) {
            if (in_array($coluna, $this->_dbTable->info('cols')))
                $ret[$coluna] = $valor;
        }

        return $ret;
    }

    /**
     * Retorna o total de registros
     * @access public
     * @return int $total
     */
    public function getTotal() {
        try {
            $where = $this->_dbTable->select()->where($this->_where);
            $resultSet = $this->_dbTable->fetchAll($where);
            $total = count($resultSet);

            return $total;
        } catch (Exception $e) {
            $log = new Logger('Classe Mapper - Metodo GetTotal ', "Query: {$where} \r\n {$e->getMessage()} \n linha: {$e->getLine()} \n arquivo: {$e->getFile()}");
            $log->createLog('log');
        }
    }

    /**
     * Deleta registro
     * @access public
     * @return boolean $del
     */
    public function delete() {
        try {
            $del = $this->_dbTable->delete($this->_where);

            if ($del)
                return true;
            else
                return false;
        } catch (Exception $e) {
            $log = new Logger('Classe Mapper - Metodo delete ', "Query: {$this->_where} \n {$e->getMessage()} \n linha: {$e->getLine()} \n arquivo: {$e->getFile()}");
            $log->createLog('log');
        }
    }

    /**
     * Monta uma query sql livre
     * @access public
     * @param string $sql
     * @return array $result
     */
    public function getSql($sql) {

        try {
            $resultSet = $this->_dbTable->getAdapter()->fetchAll($sql);
            $result = array();

            foreach ($resultSet as $row) {
                $result[] = $row;
            }

            return $resultSet;
        } catch (Exception $e) {
            $log = new Logger('Classe Mapper - Metodo GetSql ', "Query: {$sql} \n {$e->getMessage()} \n linha: {$e->getLine()} \n arquivo: {$e->getFile()}");
            $log->createLog('log');
        }
    }

}

