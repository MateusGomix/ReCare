#Usuário de acesso
#CREATE USER 'UsuarioReCare'@'localhost' IDENTIFIED BY 'Senharecare123@';
#GRANT ALL PRIVILEGES ON ReCare . * TO 'UsuarioReCare'@'localhost';	

CREATE DATABASE ReCare;

#CRIANDO A TABELA PAI PESSOA
CREATE TABLE Pessoa(
						ID_Pessoa integer UNSIGNED NOT NULL AUTO_INCREMENT,
                        Nome varchar(50),
                        CPF BIGINT,
                        DataNascimento date,
                        Telefone BIGINT,
                        Email varchar(50),
                        Senha varchar(50),
PRIMARY KEY(ID_Pessoa));

#CRIANDO A ESPECIALIZAÇÃO DE PACIENTE
CREATE TABLE Paciente(
						ID_Paciente integer UNSIGNED NOT NULL,
                        TelefoneContato BIGINT,
                        ID_Cuidador integer UNSIGNED,
                        ID_Medico integer UNSIGNED,
PRIMARY KEY(ID_Paciente),
FOREIGN KEY(ID_Paciente) REFERENCES Pessoa(ID_Pessoa),
FOREIGN KEY(ID_Cuidador) REFERENCES Pessoa(ID_Pessoa),
FOREIGN KEY(ID_Medico) REFERENCES Pessoa(ID_Pessoa));

#CRIANDO A ESPECIALIZAÇÃO DE MEDICO
CREATE TABLE Medico(
						ID_Medico integer UNSIGNED NOT NULL,
                        CRM integer,
PRIMARY KEY(ID_Medico),
FOREIGN KEY(ID_Medico) REFERENCES Pessoa(ID_Pessoa));

CREATE TABLE Admin(
						ID_Admin integer UNSIGNED NOT NULL,
PRIMARY KEY(ID_Admin),
FOREIGN KEY(ID_Admin) REFERENCES Pessoa(ID_Pessoa));

CREATE TABLE Hospital(
						ID_Hospital integer UNSIGNED NOT NULL AUTO_INCREMENT,
                        Nome varchar(50),
                        Endereco varchar(50),
                        Telefone BIGINT,
                        ID_Admin integer UNSIGNED,
PRIMARY KEY(ID_Hospital),
FOREIGN KEY(ID_Admin) REFERENCES Pessoa(ID_Pessoa));

CREATE TABLE Sensor(
						ID_Sensor integer UNSIGNED NOT NULL AUTO_INCREMENT,
                        Tipo varchar(50),
                        Frequencia float,
                        Lim_Inf float,
                        Lim_Sup float,
                        ID_Paciente integer UNSIGNED,
                        ID_Hospital integer UNSIGNED,
                        ID_Medico integer UNSIGNED,
PRIMARY KEY(ID_Sensor),
FOREIGN KEY(ID_Paciente) REFERENCES Pessoa(ID_Pessoa),
FOREIGN KEY(ID_Hospital) REFERENCES Hospital(ID_Hospital),
FOREIGN KEY(ID_Medico) REFERENCES Pessoa(ID_Pessoa));

CREATE TABLE Sinal(
						ID_Sinal integer UNSIGNED NOT NULL AUTO_INCREMENT,
                        ID_Sensor integer UNSIGNED NOT NULL,
                        DataSinal date,
                        Hora time,
                        Valor float,
PRIMARY KEY(ID_Sinal, ID_Sensor),
FOREIGN KEY(ID_Sensor) REFERENCES Sensor(ID_Sensor));

CREATE TABLE AtendeEm(
						ID_Medico integer UNSIGNED NOT NULL,
                        ID_Hospital integer UNSIGNED NOT NULL,
PRIMARY KEY(ID_Medico, ID_Hospital),
FOREIGN KEY(ID_Medico) REFERENCES Pessoa(ID_Pessoa),
FOREIGN KEY(ID_Hospital) REFERENCES Hospital(ID_Hospital));
