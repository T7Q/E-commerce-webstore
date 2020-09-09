<?php
    $hn = 'localhost';
    $db_user = 'root';
    $db_pw = 'base20';
    $db = 'db_shop';

    // create connection and check connection
    $connect = mysqli_connect($hn, $db_user, $db_pw);
    if (mysqli_connect_error()) die('Connection failed');

    // created database if it doesn exist
    $query = @mysqli_query($connect, "CREATE DATABASE IF NOT EXISTS $db") OR
    die('Error creating database: ' . mysqli_error($connect));

    mysqli_close($conn);

    // connect with created db and check connection
    $db_connect = @mysqli_connect($hn, $db_user, $db_pw, $db) OR
    die('Could not connect to MySQL: ' . mysqli_connect_error());


    // Table structre of `categories`
    $sql = "CREATE TABLE IF NOT EXISTS category (
    id_category TINYINT(4) NOT NULL,
    category_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_category)
    )ENGINE = InnoDB";

    @mysqli_query($db_connect, $sql) OR
    die ('Error creating `category` table: ') . mysqli_error($db_connect);

    // loading data for `categories from csv file

    $sql = "SELECT * FROM db_shop.category";
    $query = mysqli_query($db_connect, $sql);
    $row = mysqli_fetch_array($query);
    if ($row == 0){
        $sql = "INSERT INTO db_shop.category (`id_category`, `category_name`) VALUES ('1', 'cookies'), ('2', 'cakes'), ('3', 'subscription box')";
        @mysqli_query($db_connect, $sql) OR
        die ('Error inserting data `cat` table: ') . mysqli_error($db_connect);
    }

    // sql to create table with items

    $sql = "CREATE TABLE IF NOT EXISTS `items` (
		id_item int(11) NOT NULL AUTO_INCREMENT,
        item_name VARCHAR(800) NOT NULL,
        price FLOAT NOT NULL,
        description VARCHAR(3000) NOT NULL,
        img VARCHAR(1000) NOT NULL,
        PRIMARY KEY(id_item)
        )ENGINE = InnoDB";

    @mysqli_query($db_connect, $sql) OR
    die ('Error creating `items` table: ') . mysqli_error($db_connect);
 
    // load data to table 'product' if it doesnt exist
    $sql = "SELECT * FROM items";
    if(!mysqli_num_rows(mysqli_query($db_connect,$sql)))
    {
        $sql = "LOAD DATA LOCAL INFILE './db/items.csv'
            INTO TABLE items
            FIELDS TERMINATED BY ',' 
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\n'
            IGNORE 1 ROWS
            ";
        @mysqli_query($db_connect, $sql) OR
        die ('Error filling `items` table: ') . mysqli_error($db_connect);
    }

    // Table structre of `users`
    $sql = "CREATE TABLE IF NOT EXISTS users (
		id_customer INT(11) NOT NULL AUTO_INCREMENT,
        login VARCHAR(100) NOT NULL,
        password VARCHAR(1000) DEFAULT NULL,
        type VARCHAR(50) DEFAULT 'user',
        PRIMARY KEY (id_customer),
		first_name VARCHAR(100) DEFAULT NULL,
		last_name VARCHAR(100)DEFAULT NULL,
		phone VARCHAR(100) DEFAULT NULL,
		address VARCHAR(100) DEFAULT NULL,
		email VARCHAR(100) DEFAULT NULL
		)ENGINE = InnoDB";

    @mysqli_query($db_connect, $sql) OR
    die ('Error creating `users` table: ') . mysqli_error($db_connect);
    
    $sql = "SELECT * FROM db_shop.users WHERE login = 'admin'";
	$query = mysqli_query($db_connect, $sql);
	$hashed_passwd_admin = hash('whirlpool', 'admin');
    $row = mysqli_fetch_array($query);
    if ($row == 0){
        $sql = "INSERT INTO db_shop.users (`login`, `password`, `type`) VALUES ('admin', '$hashed_passwd_admin', 'admin')";
        @mysqli_query($db_connect, $sql) OR
        die ('Error inserting data `users` table: ') . mysqli_error($db_connect);
    }
    
    
    $sql = "CREATE TABLE IF NOT EXISTS `itemcategory` (
        `id_item` int(11) NOT NULL,
        `id_category` TINYINT(4) NOT NULL,
        PRIMARY KEY (`id_item`, `id_category`),
        CONSTRAINT `Constr_itemcategory_item_fk`
        FOREIGN KEY `item_fk` (`id_item`) REFERENCES `items` (`id_item`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `Constr_itemcategory_category_fk`
        FOREIGN KEY `category_fk` (`id_category`) REFERENCES `category` (`id_category`)
        ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE = InnoDB";
      @mysqli_query($db_connect, $sql) OR
      die ('Error creating `itemcategory` table: ') . mysqli_error($db_connect);
      
      
      $sql = "SELECT * FROM `itemcategory`";
      if(!mysqli_num_rows(mysqli_query($db_connect,$sql)))
      {
          $sql = "LOAD DATA LOCAL INFILE './db/item_cat.csv'
          INTO TABLE itemcategory
          FIELDS TERMINATED BY ',' 
          ENCLOSED BY '\"'
          LINES TERMINATED BY '\n'
          IGNORE 1 ROWS
          ";
          @mysqli_query($db_connect, $sql) OR
          die ('Error filling `itemcategory` table: ') . mysqli_error($db_connect);
        }

        $sql = "CREATE TABLE IF NOT EXISTS `orders` (
            id_order INT(11) NOT NULL AUTO_INCREMENT,
            id_customer INT(11) NOT NULL REFERENCES `users` (id_customer),
            total FLOAT NOT NULL,
            purchase_date DATE,
            PRIMARY KEY(id_order)
            )ENGINE = InnoDB";
    
        @mysqli_query($db_connect, $sql) OR
        die ('Error creating `order` table: ') . mysqli_error($db_connect);

    $sql = "CREATE TABLE IF NOT EXISTS `order_details` (
            id_details int(11) NOT NULL AUTO_INCREMENT,
            id_order INT(11) NOT NULL REFERENCES orders (id_order),
            id_item int(11) NOT NULL REFERENCES items (id_item),
            quantity int(11) NOT NULL,
            price FLOAT NOT NULL,
            purchase_date DATE,
            PRIMARY KEY(id_details)
            ) ENGINE = InnoDB";
    
        @mysqli_query($db_connect, $sql) OR
        die ('Error creating `order details` table: ') . mysqli_error($db_connect);
?>



