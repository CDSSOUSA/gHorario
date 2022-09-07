DROP DATABASE bd_sisHorario;
CREATE DATABASE bd_sisHorario;
USE bd_sisHorario;
CREATE TABLE IF NOT EXISTS tb_discipline (
    id SMALLINT AUTO_INCREMENT NOT NULL,
    description VARCHAR(100),
    abbreviation VARCHAR(8),
    amount SMALLINT,
    CONSTRAINT id_pk PRIMARY KEY (id)
) ENGINE = INNODB;
INSERT INTO tb_discipline (description, abbreviation, amount)
VALUES ('GEOGRAFIA', 'GEO', 4),
    ('HISTÓRIA', 'HIST', 3),
    ('PORTUGUÊS', 'PORT', 5),
    ('INGLÊS', 'ING', 3),
    ('MATEMÁTICA', 'MAT', 5),
    ('ARTES', 'ART', 3),
    ('FILOSOFIA', 'FILO', 3),
    ('EDUCAÇÃO FÍSICA', 'ED FÍS', 3),
    ('CIÊNCIAS', 'CIÊ', 3);
CREATE TABLE tb_teacher (
    id SMALLINT AUTO_INCREMENT NOT NULL,
    name VARCHAR (200) NOT NULL,
    color CHAR(7),
    status CHAR(1) COMMENT 'A-ATIVO I-INATIVO',
    amount SMALLINT,
    CONSTRAINT id_pk PRIMARY KEY (id)
) ENGINE = INNODB;
INSERT INTO tb_teacher (name, color, status, amount)
VALUES ('LÍBIO', '#3C0BF3', 'A', 4),
    ('MARIA', '#A00E2A', 'A', 3),
    ('MICHELLE', '#0481D7', 'A', 4),
    ('SILVANA', '#CC4567', 'A', 4),
    ('ARMÊNIO', '#FF1400', 'A', 2),
    ('MICHILLYS', '#FF1400', 'A', 2),
    ('ROSILENE', '#FF1400', 'A', 2),
    ('MARCIO', '#FF1400', 'A', 2),
    ('JOSILÂNDIA', '#FF1400', 'A', 2),
    ('MÁRCIO', '#FF1400', 'A', 2),
    ('ALEX', '#FF1400', 'A', 2),
    ('TESSÁLIA', '#FF1400', 'A', 2),
    ('LUÍS', '#FF1400', 'A', 2),
    ('MARCELA', '#FF1400', 'A', 2),
    ('LYUSKA', '#FF1400', 'A', 2),
    ('DANIELY', '#FF1400', 'A', 2),
    ('VANDA', '#FF1400', 'A', 2),
    ('JOSIELMA', '#FF1400', 'A', 2),
    ('ISRAEL', '#FF1400', 'A', 2),
    ('JOSMARA', '#FF1400', 'A', 2);
    

CREATE TABLE tb_teacher_discipline(
    id INT AUTO_INCREMENT NOT NULL,
    id_teacher SMALLINT,
    id_discipline SMALLINT,
    amount SMALLINT,
    color CHAR(7),
    CONSTRAINT id_pk PRIMARY KEY (id),
    CONSTRAINT id_teacher_fk FOREIGN KEY (id_teacher) REFERENCES tb_teacher (id),
    CONSTRAINT id_discipline_fk FOREIGN KEY (id_discipline) REFERENCES tb_discipline (id)
) ENGINE = INNODB;
INSERT INTO tb_teacher_discipline (id_teacher, id_discipline, amount,color)
VALUES (1, 1, 2, '#3C0BF3'),
       (1, 2, 2, '#908734'),
       (2, 2, 3, '#A00E2A'),
       (3, 5, 5, '#0481D7'),
       (4, 7, 3, '#CC4567');

CREATE TABLE tb_allocation(
    id INT AUTO_INCREMENT NOT NULL,
    id_teacher_discipline INT,
    dayWeek CHAR(1),
    position CHAR(1),
    situation CHAR(1) COMMENT 'L-LIVRE E O-OCUPADO',
    status CHAR(1) COMMENT 'A-ATIVO I-INATIVO',
    shift CHAR(1) COMMENT 'M-MANHA T-TARDE',
    CONSTRAINT id_pk PRIMARY KEY (id),
    CONSTRAINT id_teacher_discipline_fk FOREIGN KEY (id_teacher_discipline) REFERENCES tb_teacher_discipline(id)
) ENGINE = INNODB;

INSERT INTO tb_allocation (id_teacher_discipline, dayWeek, position, situation, status ) VALUES 
(1,'2','1','O','A'),
(2,'2','2','O','A'),
(3,'3','1','L','A'),
(4,'2','2','L','A'),
(5,'2','4','L','A'),
(2,'2','6','L','A'),
(5,'2','3','L','A'),
(4,'2','3','L','A');

CREATE TABLE tb_series(
  id SMALLINT AUTO_INCREMENT NOT NULL,
  description VARCHAR(2),
  classification CHAR(1),
  shift CHAR(1),
  CONSTRAINT id_pk PRIMARY KEY (id)
)ENGINE = INNODB;

INSERT INTO tb_series(description,classification,shift) VALUES
('6','A','M'),
('6','B','M'),
('6','C','M'),
('6','D','M'),
('7','A','M'),
('7','B','M'),
('7','C','M'),
('7','D','M'),
('9','A','M'),
('9','B','M'),
('9','C','M'),
('8','A','T'),
('8','B','T'),
('8','C','T'),
('8','D','T');

CREATE TABLE tb_school_schedule(
    id INT AUTO_INCREMENT NOT NULL,
    id_allocation INT,
    dayWeek CHAR(1),
    position CHAR(1),
    id_series SMALLINT,
    status CHAR(1) COMMENT 'A-ATIVO I-INATIVO',
    CONSTRAINT id_pk PRIMARY KEY (id),
    CONSTRAINT id_allocation_fk FOREIGN KEY (id_allocation) REFERENCES tb_allocation(id),
    CONSTRAINT id_series_fk FOREIGN KEY (id_series) REFERENCES tb_series(id)
)ENGINE = INNODB;

INSERT INTO tb_school_schedule (id_allocation,dayWeek,position,id_series,status) VALUES
(1,'2','1',1,'A'),
(2,'2','2',1,'A');


