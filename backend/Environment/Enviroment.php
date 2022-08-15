<?php

    class Enviroment {
        private $connectionProperties = [
            "host" => "localhost",
            "dbName" => "market",
            "user" => "postgres",
            "password" => "root",
        ];

        public function getConnectionProperties() {
            return $this->connectionProperties;
        }
    }

