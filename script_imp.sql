create table liabilities (
    id int primary key auto_increment,
    quantity double,
    immo_id int,
    date datetime,
    foreign key (immo_id) references immobilisations(id)
);

select ((select sum(amount) from inventory_in where product_id = 1) - (select sum(amount) from inventory_out where product_id = 1)) / ((select sum(quantity) from inventory_in where product_id = 1) - (select sum(quantity) from inventory_out where product_id = 1));
