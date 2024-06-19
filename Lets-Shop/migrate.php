<?php
system("clear");
require_once "global.php";
require_once CoreDir."/functions.php";
require_once ModelDir."/DBConfig.php";

$connection = new DBConfig();
$connection->dropAllTable();

// Creating stocks table
$connection->createTable("stocks",
    "`id` INT NOT NULL AUTO_INCREMENT",
    "`quantity` INT NOT NULL",
    "`last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
    "PRIMARY KEY (`id`)"
);

// Creating discounts table
$connection->createTable("discounts",
    "`id` INT NOT NULL AUTO_INCREMENT",
    "`name` VARCHAR(30) NOT NULL",
    "`description` VARCHAR(50) NOT NULL",
    "`percentage` DECIMAL(5,2) NOT NULL",
    "`active_discount` BOOLEAN NOT NULL",
    "`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
    "PRIMARY KEY (`id`)"
);

// Creating categories table
$connection->createTable("categories",
    "`id` INT NOT NULL AUTO_INCREMENT",
  "`name` VARCHAR(40) NOT NULL",
    "`description` VARCHAR(50) NOT NULL",
    "`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
    "PRIMARY KEY (`id`)"
);

// Creating products table
$connection->createTable("products",
    "`id` INT NOT NULL AUTO_INCREMENT",
    "`name` VARCHAR(50) NOT NULL",
    "`description` VARCHAR(200) NOT NULL",
    "`price` DECIMAL(10,2) NOT NULL",
    "`stock_id` INT NOT NULL",
    "`discount_id` INT NULL",
    "`active_sale` BOOLEAN NOT NULL",
    "`product_img` VARCHAR(260) NOT NULL",
    "`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
    "PRIMARY KEY (`id`)",
    "FOREIGN KEY (stock_id) REFERENCES stocks(id)",
    "FOREIGN KEY (discount_id) REFERENCES discounts(id)"
);

// Creating product_category_relation table
$connection->createTable("product_category_relation",
    "`product_id` INT NOT NULL",
    "`category_id` INT NOT NULL",
    "PRIMARY KEY (`product_id`, `category_id`)",
    "FOREIGN KEY (product_id) REFERENCES products(id)",
    "FOREIGN KEY (category_id) REFERENCES categories(id)",
);

// Creating roles table
$connection->createTable("roles",
    "`id` INT NOT NULL AUTO_INCREMENT",
    "`role_name` VARCHAR(20) NOT NULL",
    "PRIMARY KEY (`id`)"
);

// Creating states table
$connection->createTable("states",
    "`id` INT NOT NULL AUTO_INCREMENT",
    "`name` VARCHAR(20) NOT NULL",
    "`active_state` BOOLEAN NOT NULL",
    "`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
    "PRIMARY KEY (`id`)"
);

// Creating towns table
$connection->createTable("towns",
    "`id` INT NOT NULL AUTO_INCREMENT",
    "`name` VARCHAR(30) NOT NULL",
    "`delivery_price` DECIMAL(10,2) NOT NULL",
    "`state_id` INT NOT NULL",
    "`added_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
    "PRIMARY KEY (`id`)",
    "FOREIGN KEY (state_id) REFERENCES states(id)"
);

// Creating delivery_addresses table
$connection->createTable("delivery_addresses",
    "`id` INT NOT NULL AUTO_INCREMENT",
    "`state_id` INT NOT NULL",
    "`town_id` INT NOT NULL",
    "`detail_address` VARCHAR(60) NOT NULL",
    "`phone_num` VARCHAR(15) NOT NULL",
    "`user_id` INT NOT NULL",
    "PRIMARY KEY (`id`)",
    "FOREIGN KEY (state_id) REFERENCES states(id)",
    "FOREIGN KEY (town_id) REFERENCES towns(id)"
);

// Creating users table
$connection->createTable("users",
    "`id` INT NOT NULL AUTO_INCREMENT",
    "`name` VARCHAR(20) NOT NULL",
    "`email` VARCHAR(50) NOT NULL",
    "`password` CHAR(64) NOT NULL",
    "`phone` VARCHAR(20) NULL",
    "`role_id` INT NOT NULL",
    "`gender` ENUM('male','female') NULL",
    "`default_delivery_address_id` INT NULL",
    "`profile_img` VARCHAR(260) NULL",
    "`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
    "PRIMARY KEY (`id`)",
    "FOREIGN KEY (role_id) REFERENCES roles(id)",
    "FOREIGN KEY (default_delivery_address_id) REFERENCES delivery_addresses(id)"
);

// Creating orders table
$connection->createTable("orders",
"`id` INT NOT NULL AUTO_INCREMENT",
    "`product_id` INT NOT NULL",
    "`quantity_sold` INT NOT NULL",
    "`price_per_unit` DECIMAL(10,2) NOT NULL",
    "`total_price` DECIMAL(10,2) NOT NULL",
    "`discount_per_unit` DECIMAL(10,2) NULL",
    "`total_discount` DECIMAL(10,2) NULL",
    "`delivery_price` DECIMAL(10,2) NOT NULL",
    "`grand_total` DECIMAL(10,2) NOT NULL",
    "`delivery_info_id` INT NOT NULL",
    "`is_confirmed` INT NOT NULL",
    "`ordered_at` INT NOT NULL",
    "`user_id` INT NOT NULL",
    "PRIMARY KEY (`id`)",
    "FOREIGN KEY (delivery_info_id) REFERENCES delivery_addresses(id)",
    "FOREIGN KEY (product_id) REFERENCES products(id)",
    "FOREIGN KEY (user_id) REFERENCES users(id)"
);

// Creating wishes table
$connection->createTable("wishes",
    "`product_id` INT NOT NULL",
    "`user_id` INT NOT NULL",
    "PRIMARY KEY (`product_id`, `user_id`)",
    "FOREIGN KEY (product_id) REFERENCES products(id)",
    "FOREIGN KEY (user_id) REFERENCES users(id)",
);

// Creating carts table
$connection->createTable("carts",
    "`product_id` INT NOT NULL",
    "`user_id` INT NOT NULL",
    "PRIMARY KEY (`product_id`, `user_id`)",
    "FOREIGN KEY (product_id) REFERENCES products(id)",
    "FOREIGN KEY (user_id) REFERENCES users(id)",
);