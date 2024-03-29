DROP DATABASE bd_sisHorario;
CREATE DATABASE bd_sisHorario;
USE bd_sisHorario;

CREATE TABLE IF NOT EXISTS tb_year_school (
    id SMALLINT AUTO_INCREMENT NOT NULL,
    description CHAR(4),
    status CHAR(1) COMMENT 'A-ATIVO I-INATIVO',
    CONSTRAINT id_pk PRIMARY KEY (id)
) ENGINE = INNODB;
INSERT INTO tb_year_school (description, status) VALUES ('2023','A');

CREATE TABLE IF NOT EXISTS tb_discipline (
    id SMALLINT AUTO_INCREMENT NOT NULL,
    description VARCHAR(100),
    abbreviation VARCHAR(8),
    amount SMALLINT,
    icone VARCHAR(25),
    CONSTRAINT id_pk PRIMARY KEY (id)
) ENGINE = INNODB;
INSERT INTO tb_discipline (description, abbreviation, amount, icone)
VALUES ('GEOGRAFIA', 'GEO', 3,'icon-geografia.png'),
    ('HISTÓRIA', 'HIST', 4,'icon-historia.png'),
    ('PORTUGUÊS', 'PORT', 5,'icon-portugues.png'),
    ('INGLÊS', 'ING', 2,'icon-ingles.png'),
    ('MATEMÁTICA', 'MAT', 5,'icon-matematica.png'),
    ('ARTES', 'ART', 2,'icon-artes.png'),
    ('FILOSOFIA', 'FILO', 2,'icon-filosofia.png'),
    ('EDUCAÇÃO FÍSICA', 'ED FÍS', 2,'icon-edfisica.png'),
    ('CIÊNCIAS', 'CIÊ', 3,'icon-ciencias.png');

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
    ('ALEX', '#FF1400', 'A', 2),
    ('TESSÁLIA', '#FF1400', 'A', 2),
    ('LUÍS', '#FF1400', 'A', 2),
    ('MARCELA', '#FF1400', 'A', 2),
    ('LYUSKA', '#FF1400', 'A', 2),
    ('DANIELY', '#FF1400', 'A', 2),
    ('VANDA', '#FF1400', 'A', 2),
    ('JOSIELMA', '#FF1400', 'A', 2),
    ('ISRAEL', '#FF1400', 'A', 2),
    ('JOSMARA', '#FF1400', 'A', 2),
    ('ÉLLYDA', '#FF1400', 'A', 2);
    

CREATE TABLE tb_teacher_discipline(
    id INT AUTO_INCREMENT NOT NULL,
    id_teacher SMALLINT,
    id_discipline SMALLINT,
    id_year_school SMALLINT,
    amount SMALLINT,
    color CHAR(7),
    status CHAR(1) COMMENT 'A-ATIVO I-INATIVO',
    CONSTRAINT id_pk PRIMARY KEY (id),
    CONSTRAINT id_teacher_fk FOREIGN KEY (id_teacher) REFERENCES tb_teacher (id) ON DELETE CASCADE,
    CONSTRAINT id_discipline_fk FOREIGN KEY (id_discipline) REFERENCES tb_discipline (id),
    CONSTRAINT id_year_teacher_discipline_fk FOREIGN KEY (id_year_school) REFERENCES tb_year_school (id),
    CONSTRAINT id_unique_teac_disc UNIQUE (id_teacher,id_discipline,id_year_school,status)
) ENGINE = INNODB;

CREATE TABLE tb_allocation(
    id INT AUTO_INCREMENT NOT NULL,
    id_teacher_discipline INT,
    dayWeek CHAR(1),
    position CHAR(1),
    situation CHAR(1) COMMENT 'L-LIVRE E O-OCUPADO',
    status CHAR(1) COMMENT 'A-ATIVO I-INATIVO',
    shift CHAR(1) COMMENT 'M-MANHA T-TARDE',
    id_year_school SMALLINT,
    CONSTRAINT id_pk PRIMARY KEY (id),
    CONSTRAINT id_teacher_discipline_fk FOREIGN KEY (id_teacher_discipline) REFERENCES tb_teacher_discipline(id) ON DELETE CASCADE,
    CONSTRAINT id_year_allocation_fk FOREIGN KEY (id_year_school) REFERENCES tb_year_school (id)
) ENGINE = INNODB;

CREATE TABLE tb_series(
  id SMALLINT AUTO_INCREMENT NOT NULL,
  description VARCHAR(2),
  classification CHAR(1),
  shift CHAR(1),
  id_year_school SMALLINT,
  status CHAR(1) COMMENT 'A-ATIVO I-INATIVO',
  CONSTRAINT id_pk PRIMARY KEY (id),
  CONSTRAINT id_year_series_fk FOREIGN KEY (id_year_school) REFERENCES tb_year_school (id),
  CONSTRAINT serie_uk UNIQUE(description,classification,shift,id_year_school,status)
)ENGINE = INNODB;

INSERT INTO tb_series(description,classification,shift,id_year_school,status) VALUES
('6','A','T',1,'A'),
('6','B','T',1,'A'),
('6','C','T',1,'A'),
('6','D','T',1,'A'),
('7','A','M',1,'A'),
('7','B','M',1,'A'),
('7','C','M',1,'A'),
('7','D','M',1,'A'),
('9','A','M',1,'A'),
('9','B','M',1,'A'),
('9','C','M',1,'A'),
('8','A','M',1,'A'),
('8','B','M',1,'A'),
('8','C','M',1,'A'),
('8','D','M',1,'A');

CREATE TABLE tb_school_schedule(
    id INT AUTO_INCREMENT NOT NULL,
    id_allocation INT,
    dayWeek CHAR(1),
    position CHAR(1),
    id_series SMALLINT,
    id_year_school SMALLINT,
    status CHAR(1) COMMENT 'A-ATIVO I-INATIVO',
    CONSTRAINT id_pk PRIMARY KEY (id),
    CONSTRAINT id_allocation_fk FOREIGN KEY (id_allocation) REFERENCES tb_allocation(id) ON DELETE CASCADE,
    CONSTRAINT id_series_fk FOREIGN KEY (id_series) REFERENCES tb_series(id),
    CONSTRAINT id_year_schedulefk FOREIGN KEY (id_year_school) REFERENCES tb_year_school (id)
)ENGINE = INNODB;

CREATE TABLE tb_config (
	id INT AUTO_INCREMENT NOT NULL,
	qtde_dayWeek SMALLINT,
	start_dayWeek CHAR(1),
	end_dayWeek CHAR(1),
	qtde_position SMALLINT,	
	id_year_school SMALLINT,
    class_time SMALLINT,
    shift VARCHAR(6),
    status CHAR(1) COMMENT 'A-ATIVO I-INATIVO',
    CONSTRAINT id_pk PRIMARY KEY (id),
    CONSTRAINT id_year_config_fk FOREIGN KEY (id_year_school) REFERENCES tb_year_school (id)
)ENGINE = INNODB;

INSERT INTO tb_config (qtde_dayWeek, start_dayWeek, end_dayWeek, qtde_position, id_year_school, class_time, shift, status) VALUES (5,2,6,6,1,45,'M;T;N;','A');
