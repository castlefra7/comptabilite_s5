create database immobilisation;
use immobilisation;

create table suppliers (
    id int primary key auto_increment,
    name varchar(255)
);

create table services (
    id int primary key auto_increment,
    name varchar(255)
);

create table immobilisations (
    id int primary key auto_increment,
    code varchar(10),
    designation varchar(255),
    buy_date datetime,
    usage_date datetime,
    supplier_id int,
    buy_price double,
    amortissed_year smallint,
    amortissed_rate double,
    amortissed_type  enum('1', '2'),
    unique(code),
    foreign key (supplier_id) references suppliers(id)
);

create table inventories (
    id int primary key auto_increment,
    immo_id int,
    inv_date datetime,
    inv_state varchar(10),
    description text,
    foreign key (immo_id) references immobilisations(id)
);

create table assignment_history (
    id int primary key auto_increment,
    immo_id int,
    assign_date datetime,
    service_id int,
    description text,
    foreign key (immo_id) references immobilisations(id),
    foreign key (service_id) references services(id)
);

create table maintenance_history (
    id int primary key auto_increment,
    immo_id int,
    description_repairer text,
    maintenance_date_begin datetime,
    maintenance_date_end datetime,
    description_maintenance text,
    foreign key (immo_id) references immobilisations(id)
);


create table products (
    id int primary key auto_increment,
    code varchar(255),
    name varchar(100),
    inventory_method varchar(4) CHECK (inventory_method IN ('CMUP', 'FIFO', 'LIFO')),
    unique(code)
);


create table inventory_in (
    id int primary key auto_increment,
    product_id int,
    unit_price double,
    quantity double,
    amount double,
    date_in date,
    foreign key (product_id) references products(id)
);


create table inventory_out (
    id int primary key auto_increment,
    product_id int,
    quantity double,
    amount double,
    unit_price double,
    date_out date,
    foreign key (product_id) references products(id)
);


create table cmup (
    id int primary key auto_increment,
    product_id int,
    amount double,
    date_cmup date,
    foreign key (product_id) references products(id)
);

create view all_entries as (select product_id, quantity, amount, unit_price, date_out as date_inv, "out" as type from inventory_out) union all (select product_id, quantity, amount, unit_price, date_in as date_inv, "in" as type from inventory_in)


select (select ((select sum(amount) as sum_ins from inventory_in where product_id = 1) - (select sum(amount) as sum_out from inventory_out where product_id = 1)))  as amount, ((select sum(quantity) as sum_ins from inventory_in where product_id = 1) - (select sum(quantity) as sum_out from inventory_out where product_id = 1)) as quantity, -1 as unit_price, -1 as product_id;






insert into products (name, inventory_method, code) values ('imprimante', 'CMUP', 'p001');
insert into inventory_in (product_id, unit_price, quantity, amount, date_in) values (1, 5000, 5, 25000, "2021-02-01");
insert into inventory_in (product_id, unit_price, quantity, amount, date_in) values (1, 5500, 10, 55000, "2021-02-02");
insert into inventory_in (product_id, unit_price, quantity, amount, date_in) values (1, 5000, 100, 500000, "2021-02-03");


insert into inventory_out (product_id, unit_price, quantity, amount, date_out) values (1, 5000, 5, 25000, "2021-02-05");



-- insert into inventory_in (product_id, unit_price, quantity, amount, date_in) values (1, 5000, 2, 10000, '2021-01-29');
-- 