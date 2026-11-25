-- VestibaQuest MVC: banco com duas tabelas relacionadas (1 universidade -> N simulados)

CREATE DATABASE IF NOT EXISTS vestibaquest_mvc
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE vestibaquest_mvc;

DROP TABLE IF EXISTS simulado;
DROP TABLE IF EXISTS universidade;

CREATE TABLE universidade (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  sigla VARCHAR(15) NOT NULL UNIQUE,
  cidade VARCHAR(80) NOT NULL,
  tipo ENUM('Estadual','Federal','Privada') NOT NULL DEFAULT 'Estadual',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE simulado (
  id INT AUTO_INCREMENT PRIMARY KEY,
  universidade_id INT NOT NULL,
  titulo VARCHAR(120) NOT NULL,
  ano SMALLINT NOT NULL,
  area VARCHAR(40) NOT NULL,
  qtd_questoes SMALLINT NOT NULL,
  dificuldade ENUM('Fácil','Média','Difícil') NOT NULL DEFAULT 'Média',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_simulado_universidade
    FOREIGN KEY (universidade_id) REFERENCES universidade(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO universidade (nome, sigla, cidade, tipo) VALUES
('Universidade Estadual de Ponta Grossa', 'UEPG', 'Ponta Grossa', 'Estadual'),
('Universidade Federal do Paraná', 'UFPR', 'Curitiba', 'Federal'),
('Universidade Estadual de Londrina', 'UEL', 'Londrina', 'Estadual'),
('Universidade Estadual de Maringá', 'UEM', 'Maringá', 'Estadual');

INSERT INTO simulado (universidade_id, titulo, ano, area, qtd_questoes, dificuldade) VALUES
(1, 'Vestibular de Verão - 1ª fase', 2024, 'Conhecimentos Gerais', 60, 'Média'),
(1, 'PSS - Etapa 3', 2023, 'Ciências da Natureza', 40, 'Difícil'),
(1, 'Vestibular de Inverno', 2023, 'Linguagens', 30, 'Fácil'),
(2, 'Vestibular 1ª fase', 2024, 'Conhecimentos Gerais', 80, 'Difícil'),
(2, 'Vestibular 2ª fase - Matemática', 2023, 'Matemática', 10, 'Difícil'),
(3, 'Vestibular 1ª fase', 2024, 'Conhecimentos Gerais', 60, 'Média'),
(4, 'Vestibular de Verão', 2024, 'Ciências Humanas', 40, 'Média');
