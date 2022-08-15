<?php

    class SalesRepository extends BaseRepository {

        public function get() {
            $query = "SELECT * FROM sales ORDER BY created_at DESC";

            $result = pg_query($this->dbConnection, $query);

            $result = pg_fetch_all($result);

            $this->disconnect();

            return $result;
        }

        public function create($sale) {

            $saleProducts = [];
            $producsTotal = 0;
            $taxesTotal = 0;

            foreach ($sale["saleProducts"] as $product) {
                $saleProducts[] = [
                    "sales_id" => "",
                    "product_id" => $product["productID"],
                    "qty" => $product["qty"],
                    "total" => $product["total"],
                ];

                $taxesTotal += $product['taxTotal'];
                $producsTotal += number_format($product["total"], 2);
            }

            $parsedSale = [
                "products_total" => $producsTotal,
                "taxes_total"   => $taxesTotal,
                "total" => $producsTotal + $taxesTotal,
            ];

            $res = pg_insert($this->dbConnection, "sales", $parsedSale);

            if (!$res) return null;

            $query = "SELECT MAX(id) FROM sales";

            $result = pg_fetch_row(pg_query($this->dbConnection, $query));

            $saleID = $result[0];

            foreach ($saleProducts as $saleProduct) {
                $saleProduct["sales_id"] = $saleID;
                $res = pg_insert($this->dbConnection, "sale_products", $saleProduct);

                $query = "SELECT MAX(id) FROM sale_products";

                $result = pg_fetch_row(pg_query($this->dbConnection, $query));
    
                $saleProductID = $result[0];

                foreach ($sale["taxes"] as $tax) {
                    if ($tax['productID'] != $saleProduct['product_id']) continue;

                    $taxValue = ($tax['value'] / 100) * $saleProduct['total'];

                    $saleProductTaxesParsed = [
                        "sale_products_id"  => $saleProductID,
                        "category_taxes_id" => $tax['category_id'],
                        "total" => number_format($taxValue, 2)
                    ];

                    $res = pg_insert($this->dbConnection, "sale_product_taxes", $saleProductTaxesParsed);
                }
            }

            $this->disconnect();

            return $res;
        }
    }