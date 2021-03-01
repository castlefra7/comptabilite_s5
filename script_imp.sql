create table liabilities (
    id int primary key auto_increment,
    quantity double,
    immo_id int,
    date datetime,
    foreign key (immo_id) references immobilisations(id)
);