<?php

    class CategoriesRepository extends BaseRepository {

        public function get() {

            $query = "SELECT * FROM categories WHERE deleted_at IS NULL";

            $result = pg_query($this->dbConnection, $query);

            $result = pg_fetch_all($result);

            $this->disconnect();

            return $result;
        }

        public function create($category) {

            $taxes = $category['taxes'];

            $parsedCategory = [
                'name' => $category['name'],
                'unit' => $category['unit'],
            ];

            $res = pg_insert($this->dbConnection, "categories", $parsedCategory);

            if (!$res) return null;


            if (count($taxes) > 0) {

                $query = "SELECT MAX(id) FROM categories";

                $result = pg_fetch_row(pg_query($this->dbConnection, $query));

                $categoryID = $result[0];

                foreach ($taxes as $tax) {
                    $parsedTax = [
                        "category_id" => $categoryID,
                        "name" => $tax['tax'],
                        "value" => $tax['percentage'],
                    ];

                    $res = pg_insert($this->dbConnection, "category_taxes", $parsedTax);
                }
            }

            $this->disconnect();

            return $res;
        }

        public function deleteCategory($categoryID) {
         
            $query = "SELECT * FROM category_taxes WHERE category_id = $categoryID";

            $result = pg_fetch_all(pg_query($this->dbConnection, $query));

            if ($result) {
                $dateleTaxesQuery = "UPDATE category_taxes SET deleted_at = NOW() WHERE category_id = $categoryID";

                $result = pg_query($this->dbConnection, $dateleTaxesQuery);
            }

            $deleteCategoryQuery = "UPDATE categories SET deleted_at = NOW() WHERE id = $categoryID";

            $result = pg_query($this->dbConnection, $deleteCategoryQuery);

            $this->disconnect();

            return $result;
        }
    }