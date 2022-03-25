use student; 
create table classes( 
class_id int auto_increment primary key, 
class_no char(10) not NULL unique, 
class_name char(20) not NULL 
); 
create table course( 
course_id int auto_increment primary key, 
course_no char(10) not NULL unique, 
course_name char(20) not NULL 
); 
create table student( 
student_id int auto_increment primary key, 
student_no char(10) not NULL unique, 
student_name char(10) not NULL, 
class_id int, 
constraint FK_student_class foreign key (class_id) references classes(class_id)  
); 
create table teacher( 
teacher_id int auto_increment primary key, 
teacher_no char(10) not NULL unique, 
teacher_name char(10) not NULL, 
class_id int unique, 
constraint FK_teacher_class foreign key (class_id) references classes(class_id)  
); 
create table score( 
score_id int auto_increment primary key, 
student_id int not NULL, 
course_id int not NULL, 
grade int,  
constraint FK_score_student foreign key (student_id) references student(student_id), 
constraint FK_score_course foreign key (course_id) references course(course_id)  
); 
insert into classes(class_id,class_no,class_name) values (NULL,'10chinese','10中文'); 
insert into classes(class_id,class_no,class_name) values (NULL,'10english','10英语'); 
insert into classes values (NULL,'10maths','10数学'); 


insert into student values (NULL,'2010010101','张三',1); 

update student set student_name='张三丰' where student_id=1; 

insert into student values (2,'2010010102','李四',1);
insert into student values (3,'2010010103','王五',3);
insert into student values (4,'2010010104','马六',2);
insert into student values (5,'2010010105','田七',2);

insert into classes values (4,'10auto','10自动化');

insert into student values (6,'2010010106','赵八',null);



select student_id, student_no,student_name,classes.class_id,class_no,class_name
from student join classes on student.class_id=classes.class_id;

select student_id, student_no,student_name,classes.class_id,class_no,class_name
from student left join classes on student.class_id=classes.class_id;

select student_id, student_no,student_name,student.class_id,class_no,class_name
from student right join classes on student.class_id=classes.class_id;

select student_no,student_name,class_no,class_name 
from student,classes 
where student.class_id=classes.class_id 
and class_name= '10中文'; 