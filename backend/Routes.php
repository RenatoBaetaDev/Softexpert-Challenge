<?php

    $routes = [
        "categories" => [
            "class" => "CategoriesController",
            "GET" => "get",
            "POST" => "create",
            "DELETE" => "delete",
            "UPDATE" => "update",
        ],

        "products" => [
            "class" => "ProductsController",
            "GET" => "get",
            "POST" => "create",
            "DELETE" => "delete",
            "UPDATE" => "update",
        ],

        "sales" => [
            "class" => "SalesController",
            "GET" => "get",
            "POST" => "create",
            "UPDATE" => "update",
        ],

        "taxes" => [
            "class" => "TaxesController",
            "GET" => "get",
        ],
    ];