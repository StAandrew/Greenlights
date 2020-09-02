# Greenlights  
Central repository for all UCL Greenlights files 

For authentication, the website uses UCL SSO as well as login via form 
  
Naming conventions:  
Tables are named using sha256, where the first character is replaced accordingly:  
    Per-module tables begin with 'm'  
    Per student list tables begin with 'l'  
    Per-student per-module tables begin with 's'  
Moreover, there are 3 'main' tables:
    All students
    All modules
    Login credentials


Tables have this structure:  
Per-module tables:  
|  num   |    week   |  session   |    task    |task_duration| task_type |
|:------:|:---------:|:----------:|:----------:|:-----------:|:---------:|
|  INT   |SMALLINT(2)|VARCHAR(128)|VARCHAR(256)| SMALLINT(4) |VARCHAR(1) |
|NOT NULL|  NOT NULL |  NOT NULL  |  NOT NULL  |  NOT NULL   |DEFAULT 'I'|
|AUTO_INCREMENT|UNSIGNED|
|PRIMARY KEY|
  
Per-student-list tables:
|student_id| firstname  |  lastname  |    email   | course_code |   year    |
|:--------:|:----------:|:----------:|:----------:|:-----------:|:---------:|
|  INT(9)  |VARCHAR(128)|VARCHAR(128)|VARCHAR(128)| VARCHAR(10) |SMALLINT(2)|
| NOT NULL |   NOT NULL |  NOT NULL  |  NOT NULL  |  NOT NULL   | NOT NULL  |
|UNSIGNED|
|PRIMARY KEY|
    
Per-student per-module tables:
|      id      | week |  session   |    task    |group_number|rating|task_duration|task_type |task_actual|  comment   |  actions   |meeting_date|meeting_duration|
|:------------:|:----:|:----------:|:----------:|:----------:|:----:|:-----------:|:--------:|:---------:|:----------:|:----------:|:----------:|:--------------:|
|      INT     |INT(2)|VARCHAR(128)|VARCHAR(256)|SMALLINT(3) | ENUM | SMALLINT(4) |VARCHAR(1)|SMALLINT(4)|VARCHAR(256)|VARCHAR(256)|  DATETIME  |     INT(3)     |
|PRIMARY KEY|NOT NULL|NOT NULL  |  NOT NULL  | NOT NULL|DEFAULT NULL|NOT NULL|DEFAULT 'I'|DEFAULT NULL|DEFAULT NULL|DEFAULT NULL|DEFAULT NULL|DEFAULT NULL    |
|AUTO_INCREMENT|UNSIGNED|          |            |     |('Green', 'Amber', 'Red') |

