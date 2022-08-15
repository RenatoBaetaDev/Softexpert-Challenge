<?php

    class ProductsRepository extends BaseRepository {

        public function get() {
            $query = "SELECT * FROM products WHERE deleted_at IS NULL";

            $result = pg_query($this->dbConnection, $query);

            $result = pg_fetch_all($result);

            $this->disconnect();

            return $result;
        }

        public function create($product) {

            $parsedProduct = [
                'category_id' => $product['categoryID'],
                'name' => $product['name'],
                'value' => $product['value'],
            ];

            $res = pg_insert($this->dbConnection, "products", $parsedProduct);

            $this->disconnect();

            return $res;
        }

        public function deleteProduct($productID) {

            $deleteCategoryQuery = "UPDATE products SET deleted_at = NOW() WHERE id = $productID";

            $result = pg_query($this->dbConnection, $deleteCategoryQuery);

            $this->disconnect();

            return $result;
        }
    }