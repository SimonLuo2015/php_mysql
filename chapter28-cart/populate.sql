use book_sc;

insert into books values ('0672317842','Luke Welling and Laura Thomson','PHP and MySQL Web Development',1,49.99,
'PHP & MySQL Web Development teaches the reader to develop dynamic, secure e-commerce web sites. You will learn to integrate and implement these technologies by following real-world examples and working sample projects.');
insert into books values ('0672318040','Matt Zandstra','Sams Teach Yourself PHP4 in 24 Hours',1,24.99,
'Consisting of 24 one-hour lessons, Sams Teach Yourself PHP4 in 24 Hours is divided into five sections that guide you through the language from the basics to the advanced functions.');
insert into books values ('0672319241','Sterling Hughes and Andrei Zmi','PHP Developer\'s Cookbook',1,39.99,
'Provides a complete, solutions-oriented guide to the challenges most often faced by PHP developers\r\nWritten specifically for experienced Web developers, the book offers real-world solutions to real-world needs\r\n');

insert into categories values (1,'Internet');
insert into categories values (2,'Self-help');
insert into categories values (5,'Fiction');
insert into categories values (4,'Gardening');

insert into admin values ('admin', sha1('admin'));
