create database final default character set utf8 collate utf8_unicode_ci;
use final;

create table users(
	users_id varchar(24) primary key, 
	uname varchar(50) not null,
	users_password varchar(50) not null,
	uemail varchar(50) not null,
	users_role varchar(50) ,
	create_at date default sysdate
);

create sequence users_seq start with 1 increment by 1;  
create or replace trigger users_trigger       
before insert on users       
for each row       
begin       
select users_seq.nextval into :new.users_id from dual;  
end ; 
/ 

create table logs(
	logs_id varchar(24)  primary key,
	user_email varchar(100) not null,
	logs_content varchar(1000) not null,
	logs_date varchar(50) not null,
	create_on date default sysdate
);

create sequence logs_seq start with 1 increment by 1;  
create or replace trigger logs_trigger       
before insert on logs       
for each row       
begin       
select logs_seq.nextval into :new.logs_id from dual;  
end ; 
/

create table puser(
	puser_id varchar(24)  primary key,
	pemail varchar(50) not null,
	puser_password varchar(50) not null,
	token varchar(100),
	status number(1)
);

create sequence puser_seq start with 1 increment by 1;  
create or replace trigger puser_trigger       
before insert on puser    
for each row       
begin       
select puser_seq.nextval into :new.puser_id from dual;  
end ;  
/


create table files(
	file_id varchar(24) primary key,
	user_eamil varchar(100),
	file_path varchar(100),
	file_name varchar(100) );
create sequence file_seq start with 1 increment by 1;  
create or replace trigger file_trigger       
before insert on files    
for each row       
begin       
select file_seq.nextval into :new.file_id from dual;  
end ; 

/
alter user scott identified by tiger; 
insert into users(uname,users_password,uemail,users_role) 
values('Admin','Wzy02130.0','wangzu@phpstudywzy.xyz','Admin');
