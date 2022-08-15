<?php

    class DatabaseConnection {

        private $connection;

        private function getConnectionProperties()
        {
            $env = new Enviroment();
            return $env->getConnectionProperties();
        }

        public function connect() {
            $connectionProperties = $this->getConnectionProperties();

            $host = $connectionProperties['host'];
            $dbName = $connectionProperties['dbName'];
            $user = $connectionProperties['user'];
            $password = $connectionProperties['password'];

            $this->connection = pg_connect("host=$host dbname=$dbName user=$user password=$password");
        }

        public function getConnection() {
            return $this->connection;
        }

        public function disconnect() {
            pg_close($this->connection);
        }

    }
