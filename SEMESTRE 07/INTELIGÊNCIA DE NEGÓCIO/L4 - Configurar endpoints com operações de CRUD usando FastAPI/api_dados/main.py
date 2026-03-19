from crud.crud_main import insert_dados, ler_dados, delete_user
from data_models.models import User, Task
from datetime import datetime
from fastapi import FastAPI
from crud.crud_main import update_dados
from sqlalchemy.orm import Session
import uvicorn

app = FastAPI()

user1 = User(
             name = "pedro",
             email = "pedro@idp.edu.br",
             created = datetime.now()
             )

task1 = Task(
            created = datetime.now(),
            updated = datetime.now(),
            task = 'Estudar FastAPI',
            priority = 'Alta',
            status = 'Iniciado',
            userid = 1
            )

#insert_dados(user1)
#insert_dados(task1)

@app.get('/')
def read_root():
    return {"message": "Bem-vindo à API de Gerenciamento de Tarefas do Filipe Marra"}

@app.get('/primeiro_endpoint')
def meu_primeiro_endpoint():
    return 'Olá IDP, bora desenvolver na WEB!'

@app.get('/leitura_tabela')
def ler_tabela(entidade: int):
    if entidade == 1:
        tabela = User
    elif entidade == 2:
        tabela = Task
    else:
        return {"erro": "Entidade inválida! Escolha 1 para User ou 2 para Task."}
    
    return ler_dados(tabela)

@app.get('/user_by_name')
def ler_usuario_por_nome(nome: str):
    with Session() as session:
        usuario = session.query(User).filter_by(name=nome).first()
    if usuario:
        return usuario
    else:
        return {"erro": "Usuário não encontrado!"}


@app.post('/insert_user')
def inserir_user(nome_in:str,email_in:str):
    usuario = User(name=nome_in,email=email_in,created=datetime.now())
    insert_dados(usuario)
    return ler_dados(User)

@app.post('/insert_task')
def inserir_task(task_in:str,priority_in:str,status_in:str,uid_in:int):
    tarefa = Task(created=datetime.now(),updated=datetime.now(),task=task_in,priority=priority_in,status=status_in,userid=uid_in)
    insert_dados(tarefa)
    return ler_dados(Task)

    

@app.put('/update_user')
def update_user_id(id: int, nome: str = None, email: str = None):
    novos_dados = {}
    if nome:
        novos_dados["name"] = nome
    if email:
        novos_dados["email"] = email
    return update_dados(id, User, novos_dados)

@app.post('/insert_user')
def inserir_user(nome_in: str, email_in: str):
    usuario = User(name=nome_in, email=email_in, created=datetime.now())
    insert_dados(usuario)
    return ler_dados(User)

@app.post('/insert_task')
def inserir_task(task_in: str, priority_in: str, status_in: str, uid_in: int):
    tarefa = Task(
        created=datetime.now(),
        updated=datetime.now(),
        task=task_in,
        priority=priority_in,
        status=status_in,
        userid=uid_in
    )
    insert_dados(tarefa)
    return ler_dados(Task)


@app.put('/update_task')
def update_task_id(id: int, task: str = None, priority: str = None, status: str = None):
    novos_dados = {}
    if task:
        novos_dados["task"] = task
    if priority:
        novos_dados["priority"] = priority
    if status:
        novos_dados["status"] = status
    return update_dados(id, Task, novos_dados)

@app.delete('/del_user')
def delete_user_id(id:int):
    return delete_user(id,User)

@app.delete('/del_task')
def delete_task_id(id: int):
    return delete_user(id, Task)



if __name__ == "__main__":
    uvicorn.run(app, host='0.0.0.0', port=8888)
