<?php

    class BaseRepository {
        private $connection;
        protected $dbConnection;

        public function __construct() {
            $this->connection = new DatabaseConnection();
        
            $this->connection->connect();
        
            $this->dbConnection = $this->connection->getConnection();
        }

        public function disconnect() {

            $this->connection->disconnect();

        }
    }

