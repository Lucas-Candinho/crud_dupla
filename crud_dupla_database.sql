CREATE DATABASE crud_beisola_candinho;
USE crud_beisola_candinho;

CREATE TABLE professores(
	id_professor INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome_professor VARCHAR(45), 
    ultimo_nome_professor VARCHAR(45),
    cpf_professor VARCHAR(45),
    formacao_elementar_professor VARCHAR(255),
    maior_titulacao_professor VARCHAR(255)
);

CREATE TABLE aulas(
	id_aula INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome_aula VARCHAR(255),
    sala_aula VARCHAR(45),
    departamento_aula VARCHAR(255),
    tempo_minutos_aula DECIMAL,
    assunto_aula VARCHAR(255), -- Serve como um campo para anotações do professor para a aula
    modulo_aula VARCHAR(255) -- Por brevidade será um varchar, porém em um cenário real poderia ser uma tabela
);

CREATE TABLE diaria(
	id_diaria INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	fk_professor INT NOT NULL,
    FOREIGN KEY (fk_professor) REFERENCES professores(id_professor),
    fk_aula INT NOT NULL,
    FOREIGN KEY (fk_aula) REFERENCES aulas(id_aula)
);