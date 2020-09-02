# Greenlights  
Central repository for all UCL Greenlights files 

For authentication, the website uses UCL SSO as well as login via form 
  
Naming conventions:  
There are 3 'main' tables:  
⋅⋅*All students.  
⋅⋅*All modules.  
⋅⋅*Login credentials.  
<br>
And a lot of ables are named using sha256, where the first character is replaced accordingly:  
⋅⋅*Per-module tables begin with 'm'.  
⋅⋅*Per student list tables begin with 'l'.  
⋅⋅*Per-student per-module tables begin with 's'.  
<br>

Tables have this structure:  
**All modules table:**  
|     num      |module_name |module_hash |access_user_id|            access_user_type               |student_list_hash|
|:------------:|:----------:|:----------:|:------------:|:-----------------------------------------:|:---------------:|
|     INT      |VARCHAR(128)|VARCHAR(70) |    INT(10)   | ENUM('Lecturer', 'TA', 'Student', 'admin')|   VARCHAR(70)   |
|NOT NULL      |  NOT NULL  |  NOT NULL  |    NOT NULL  |                 NOT NULL                  |     NOT NULL    |
|AUTO_INCREMENT|            |            |    UNSIGNED  |
|PRIMARY KEY   |
  
**All students table:**  
|  num   |student_id|  firstname |  lastname  |   email    |course_code|    year   |module_name |module_hash|student_table_hash|
|:------:|:--------:|:----------:|:----------:|:----------:|:---------:|:---------:|:----------:|:---------:|:----------------:|
|  INT   |  INT(9)  |VARCHAR(128)|VARCHAR(128)|VARCHAR(128)|VARCHAR(10)|SMALLINT(2)|VARCHAR(128)|VARCHAR(64)|    VARCHAR(64)   |
|NOT NULL| NOT NULL |  NOT NULL  |  NOT NULL  |  NOT NULL  |  NOT NULL |  NOT NULL |  NOT NULL  |  NOT NULL |      NOT NULL    |
|AUTO_INCREMENT| 
|PRIMARY KEY|
  
**Credentials table:**  
|   user_id    | firstname |  lastname  |    email   |    pass    |            user_type                      |
|:------------:|:---------:|:----------:|:----------:|:----------:|:-----------------------------------------:|
|    INT(10)   |VARCHAR(64)|VARCHAR(128)|VARCHAR(128)|VARCHAR(128)| ENUM('Lecturer', 'TA', 'Student', 'admin')|
||PRIMARY KEY  |  NOT NULL |  NOT NULL  |   NOT NULL |  NOT NULL  |              NOT NULL                     |
|AUTO_INCREMENT|
  
**Per-module tables:**  
|  num   |    week   |  session   |    task    |task_duration| task_type |
|:------:|:---------:|:----------:|:----------:|:-----------:|:---------:|
|  INT   |SMALLINT(2)|VARCHAR(128)|VARCHAR(256)| SMALLINT(4) |VARCHAR(1) |
|NOT NULL|  NOT NULL |  NOT NULL  |  NOT NULL  |  NOT NULL   |DEFAULT 'I'|
|AUTO_INCREMENT|UNSIGNED|
|PRIMARY KEY|
  
**Per-student-list tables:**
|student_id| firstname  |  lastname  |    email   | course_code |   year    |
|:--------:|:----------:|:----------:|:----------:|:-----------:|:---------:|
|  INT(9)  |VARCHAR(128)|VARCHAR(128)|VARCHAR(128)| VARCHAR(10) |SMALLINT(2)|
| NOT NULL |   NOT NULL |  NOT NULL  |  NOT NULL  |  NOT NULL   | NOT NULL  |
|UNSIGNED|
|PRIMARY KEY|
    
**Per-student per-module tables:**
|      id      | week |  session   |    task    |group_number|rating|task_duration|task_type |task_actual|  comment   |  actions   |meeting_date|meeting_duration|
|:------------:|:----:|:----------:|:----------:|:----------:|:----:|:-----------:|:--------:|:---------:|:----------:|:----------:|:----------:|:--------------:|
|      INT     |INT(2)|VARCHAR(128)|VARCHAR(256)|SMALLINT(3) | ENUM | SMALLINT(4) |VARCHAR(1)|SMALLINT(4)|VARCHAR(256)|VARCHAR(256)|  DATETIME  |     INT(3)     |
|PRIMARY KEY|NOT NULL|NOT NULL  |  NOT NULL  | NOT NULL|DEFAULT NULL|NOT NULL|DEFAULT 'I'|DEFAULT NULL|DEFAULT NULL|DEFAULT NULL|DEFAULT NULL|DEFAULT NULL    |
|AUTO_INCREMENT|UNSIGNED|          |            |     |('Green', 'Amber', 'Red') |
  
Default login credentials:
|   login    |password|
|:----------:|:------:|
| admin@ucl  |ucladmin|
|lecturer@ucl|ucladmin|
|   ta@ucl   |ucladmin|
| student@ucl|ucladmin|
