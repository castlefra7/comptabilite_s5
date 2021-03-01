drop database if exists immobilisation;
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
    coefficient double,
    unique(code),
    foreign key (supplier_id) references suppliers(id)
);

create table inventories (
    id int primary key auto_increment,
    immo_id int,
    inv_date datetime,
    inv_state enum("Inutilisable", "Mauvais", "moyen", "bon"),
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

create view all_entries as 
(
    select 
        product_id, 
        quantity, 
        amount, 
        unit_price, 
        date_out as date_inv, 
        "out" as type 
    from inventory_out
) 
    union all 
(
    select 
        product_id, 
        quantity, 
        amount, 
        unit_price, 
        date_in as date_inv, 
        "in" as type 
    from inventory_in
);


select (select ((select sum(amount) as sum_ins from inventory_in where product_id = 1) - (select sum(amount) as sum_out from inventory_out where product_id = 1)))  as amount, ((select sum(quantity) as sum_ins from inventory_in where product_id = 1) - (select sum(quantity) as sum_out from inventory_out where product_id = 1)) as quantity, -1 as unit_price, -1 as product_id;

insert into products (name, inventory_method, code) values 
('Imprimante', 'CMUP', 'p001'),
('Encre Laser', 'CMUP', 'p002'),
('Unite Centrale', 'CMUP', 'p003'),
('Clavier', 'CMUP', 'p004'),
('Souris', 'FIFO', 'p005');

insert into inventory_in (product_id, unit_price, quantity, amount, date_in) values 
(1, 5000, 5, 25000, "2021-02-01"),
(1, 5500, 10, 55000, "2021-02-02"),
(1, 5000, 100, 500000, "2021-02-03");

insert into inventory_out (product_id, unit_price, quantity, amount, date_out) values 
(1, 5000, 5, 25000, "2021-02-05");

INSERT INTO suppliers (name) values 
("Mater auto"),
("Henri Fraise"),
("SICAM");

INSERT INTO services (name) VALUES
("Comptabilté"),
("Tresorerie"),
("Ressources Humaines");

INSERT INTO immobilisations (code, designation, buy_date, usage_date, supplier_id, buy_price, amortissed_year, amortissed_rate, amortissed_type) VALUES
("i001", "Toyota V8", "2021-02-01", "2021-02-02", "1", 160000000, 5, 20, "1"),
("i002", "Pneus de rechange", "2021-02-01", "2021-02-01", "2", 60000, 6, 20, "2"),
("i003", "Test", "2021-02-01", "2021-02-01", "1", 160000000, 7, 20, "1");

INSERT INTO inventories (immo_id, inv_date, inv_state, description) values
(1, "2021-03-01", "Moyen", "Mila manolo pompe essence"),
(2, "2021-03-01", "Bon", "RAS"),
(3, "2021-03-01", "Moyen", "Mila jerena matetitetika");

INSERT INTO assignment_history (immo_id, assign_date, service_id, description) VALUES
(1, "2021-03-01", 1, "Journaliere an'ny expert comptable"),
(2, "2021-03-01", 1, "Anoloana ny pneu an expert comptable"),
(3, "2021-03-01", 2, "Mijanona ao am tresor aloha");

INSERT INTO maintenance_history (immo_id, description_repairer, maintenance_date_begin, maintenance_date_end, description_maintenance) VALUES
(1, "Zozo Mecano", "2021-02-26", "2021-03-01", "Manadio Moteur");

INSERT INTO inventory_in (product_id, unit_price, quantity, amount, date_in) VALUES
(1, 80000, 3, 240000, "2021-02-12"),
(2, 20000, 4, 80000, "2021-02-12"),
(3, 3000000, 2, 6000000, "2021-02-12"),
(4, 7000, 5, 30000, "2021-02-12");

INSERT INTO inventory_out (product_id, unit_price, quantity, amount, date_out) VALUES
(4, 7000, 1, 7000, "2021-02-15");
