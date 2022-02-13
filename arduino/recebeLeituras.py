#Executar esses comandos no terminal para instalar as bibliotecas necessarias!
""" 

pip install webbot
pip install mysql.connector

"""

"""
Exemplos que serao usados pelo Daniel (So pra lembrar msm)

Paciente: Mariane Aparecida Moraes - SENSOR #1
CPF: 1492306720
SENHA: 123456

Medica: Nicole Louise Viana
CPF: 4458342770
SENHA: 123456

Cuidadora: Luana Silvana Novaes
CPF: 29772995727
SENHA: 123456

"""
#Importando as Bibliotecas:
from re import compile, fullmatch
from webbot import Browser
from getpass import getpass
from time import sleep
from mysql.connector import connect

#Expressao Regular de Verificacao de Email Valido Digitado:
verificaEmail = compile(r'([A-Za-z0-9]+[.-_])*[A-Za-z0-9]+@[A-Za-z0-9-]+(\.[A-Z|a-z]{2,})+')

#Scripts de Insercao dos Sensores no Banco de Dados:
insert_Oxi = """INSERT INTO Sinal (Valor, ID_Oxi) VALUES (%s, %s)"""
insert_Pres = """INSERT INTO Sinal (Valor, ID_Pressao) VALUES (%s, %s)"""
insert_Ritmo = """INSERT INTO Sinal (Valor, ID_Ritmo) VALUES (%s, %s)"""
insert_Temp = """INSERT INTO Sinal (Valor, ID_Temp) VALUES (%s, %s)"""

#Recebendo a senha do DB
passDB = getpass("Digite sua senha do LocalHost DB")

#Efetuando a conexao
connection = connect(host='localhost',
                                         database='recare',
                                         user='root',
                                         password=passDB)

#Criando o cursor
cursor = connection.cursor()

#Recebendo os dados para Login no TINKERCAD:
while(1):
    EMAIL = input("Digite seu email de sua conta TINKERCAD:")
    if(fullmatch(verificaEmail, EMAIL)): break

PASSWORD = getpass("Digite sua Senha da conta TINKERCAD:") #tenha certeza absoluta de a senha estar certa!

#### INICIO DO ACESSO AO SITE ###
web = Browser() #Criando a janela do navegador
web.go_to('https://www.tinkercad.com/things/0RQEmDTtmBG-aaaaa/editel?sharecode=qIAXCiYovTVuf2hCxw6KazVN_j1z5FBYxlZ8GokRe7E')
while(1): #Aguardando carregamento do site
    if(web.exists(text='Volta') == True): 
        break

#FAZENDO LOGIN NO TINKERCAD
web.click(classname='login-email-button')

while(1): #Aguardando carregamento
    if(web.exists(text='Efetuar') == True):
        break

web.type(EMAIL, into='userName')
web.click(id='verify_user_btn')
while(1): #Aguardando carregamento
    if(web.exists(text='Vindo') == True):
        break

web.type(PASSWORD, into='password')
web.click(id='btnSubmit')

while(1): #Aguardando carregamento
    if(web.exists(text='Iniciar') == True):
        break


#Inicio do scrapping dos valores simulados:
web.click('Iniciar simulação') #Iniciando a Simulacao
web.click('Código') #Abrindo a guia de codigo
web.click('Serial') #Exibindo o Serial para obter os dados

while(1): #Aguardando carregamento da Simulacao
    if(web.exists(text='Parar') == True):
        break

#Coletando 10 amostras (Pode ser mais!)
for i in range(10):
    sleep(1.5)
    currHTML = str(web.get_page_source()) #Armazenando o codigo atual da pagina em uma string
    web.click('Apag.') #Evitando Bugs -> Limpando o serial!
    currHTML = currHTML[currHTML.find('currSRead')+12:] #Cortando as partes irrelevantes às leituras
    currHTML = currHTML[:currHTML.find('currERead')] #Cortando o final do HTML que vem depois das leituras

    if(currHTML.find("Ox") == 0):#Verificando se a amostra eh valida
        linhas = currHTML.splitlines() #Separando as leituras em linhas
        oAtual = (float(linhas[0].split(':')[1])) #Separando a primeira leitura (Ox)
        pAtual = (float(linhas[1].split(':')[1])) #Separando a segunda leitura (Press)
        rAtual = (float(linhas[2].split(':')[1])) #Separando a terceira leitura (Ritmo)
        tAtual = (float(linhas[2].split(':')[1])) #Separando a quarta leitura (Temp)

        #Criando as tuplas para inserir no registro de sinais do sensor #1
        oxiAtual = (oAtual, 1) 
        presAtual = (pAtual, 1)
        bpmAtual = (rAtual, 1)
        tempAtual = (tAtual, 1)

        #Executando as insercoes
        cursor.execute(insert_Oxi, oxiAtual)
        cursor.execute(insert_Pres, presAtual)
        cursor.execute(insert_Ritmo, tempAtual)
        cursor.execute(insert_Temp, tempAtual)

        #Efetivando as insercoes realizadas
        connection.commit()
        print(cursor.rowcount, "leitura Gravada com Sucesso!")
    
if connection.is_connected():
    connection.close() #desconectando o DB
    print("MySQL connection is closed")

web.click(text='Parar')
web.close_current_tab()
