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

CREATE TABLE SensorPressao(
						ID_Pressao integer UNSIGNED NOT NULL AUTO_INCREMENT,
                        Frequencia float,
                        Lim_Inf float,
                        Lim_Sup float,
                        ID_Paciente integer UNSIGNED,
                        ID_Hospital integer UNSIGNED,
                        ID_Medico integer UNSIGNED,
PRIMARY KEY(ID_Pressao),
FOREIGN KEY(ID_Paciente) REFERENCES Pessoa(ID_Pessoa),
FOREIGN KEY(ID_Hospital) REFERENCES Hospital(ID_Hospital),
FOREIGN KEY(ID_Medico) REFERENCES Pessoa(ID_Pessoa));

CREATE TABLE SensorOxi(
						ID_Oxi integer UNSIGNED NOT NULL AUTO_INCREMENT,
                        Frequencia float,
                        Lim_Inf float,
                        Lim_Sup float,
                        ID_Paciente integer UNSIGNED,
                        ID_Hospital integer UNSIGNED,
                        ID_Medico integer UNSIGNED,
PRIMARY KEY(ID_Oxi),
FOREIGN KEY(ID_Paciente) REFERENCES Pessoa(ID_Pessoa),
FOREIGN KEY(ID_Hospital) REFERENCES Hospital(ID_Hospital),
FOREIGN KEY(ID_Medico) REFERENCES Pessoa(ID_Pessoa));

CREATE TABLE SensorRitmo(
						ID_Ritmo integer UNSIGNED NOT NULL AUTO_INCREMENT,
                        Frequencia float,
                        Lim_Inf float,
                        Lim_Sup float,
                        ID_Paciente integer UNSIGNED,
                        ID_Hospital integer UNSIGNED,
                        ID_Medico integer UNSIGNED,
PRIMARY KEY(ID_Ritmo),
FOREIGN KEY(ID_Paciente) REFERENCES Pessoa(ID_Pessoa),
FOREIGN KEY(ID_Hospital) REFERENCES Hospital(ID_Hospital),
FOREIGN KEY(ID_Medico) REFERENCES Pessoa(ID_Pessoa));

CREATE TABLE SensorTemp(
						ID_Temp integer UNSIGNED NOT NULL AUTO_INCREMENT,
                        Frequencia float,
                        Lim_Inf float,
                        Lim_Sup float,
                        ID_Paciente integer UNSIGNED,
                        ID_Hospital integer UNSIGNED,
                        ID_Medico integer UNSIGNED,
PRIMARY KEY(ID_Temp),
FOREIGN KEY(ID_Paciente) REFERENCES Pessoa(ID_Pessoa),
FOREIGN KEY(ID_Hospital) REFERENCES Hospital(ID_Hospital),
FOREIGN KEY(ID_Medico) REFERENCES Pessoa(ID_Pessoa));

CREATE TABLE Sinal(
						ID_Sinal integer UNSIGNED NOT NULL AUTO_INCREMENT,
                        ID_Pressao integer UNSIGNED,
                        ID_Oxi integer UNSIGNED,
                        ID_Ritmo integer UNSIGNED,
                        ID_Temp integer UNSIGNED,
                        dataHora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        Valor float,
PRIMARY KEY(ID_Sinal),
FOREIGN KEY(ID_Pressao) REFERENCES SensorPressao(ID_Pressao),
FOREIGN KEY(ID_Oxi) REFERENCES SensorOxi(ID_Oxi),
FOREIGN KEY(ID_Ritmo) REFERENCES SensorRitmo(ID_Ritmo),
FOREIGN KEY(ID_Temp) REFERENCES SensorTemp(ID_Temp));

CREATE TABLE AtendeEm(
						ID_Medico integer UNSIGNED NOT NULL,
                        ID_Hospital integer UNSIGNED NOT NULL,
PRIMARY KEY(ID_Medico, ID_Hospital),
FOREIGN KEY(ID_Medico) REFERENCES Pessoa(ID_Pessoa),
FOREIGN KEY(ID_Hospital) REFERENCES Hospital(ID_Hospital));
