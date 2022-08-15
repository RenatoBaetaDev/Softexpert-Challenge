<?php

    class TaxesRepository extends BaseRepository {

        public function get() {
            $query = "SELECT * FROM category_taxes";

            $result = pg_query($this->dbConnection, $query);

            $result = pg_fetch_all($result);

            $this->disconnect();
            
            return $result;
        }
    }