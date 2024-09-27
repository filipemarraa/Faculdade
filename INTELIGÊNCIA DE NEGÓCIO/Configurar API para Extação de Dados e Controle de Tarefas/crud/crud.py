# crud/crud.py
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from data_models.models import User, Task

DATABASE_URL = "sqlite:///base_tarefas.db"
engine = create_engine(DATABASE_URL, echo=True)
session = sessionmaker(bind=engine)

def ler_user(modelo):
    with session() as s:
        rows = s.query(modelo).all()
        for row in rows:
            print(row.dict())

def inserir_tasks(tasks):
    with session() as s:
        for task in tasks:
            s.add(task)
        s.commit()

def mostrar_tasks(model):
    with session() as s:
        rows = s.query(model).all()
        for row in rows:
            print(row.dict())

def get_userid(name_in):
    with session() as s:
        user = s.query(User).filter_by(name=name_in).first()
        if user is None:
            return None
        return user.id
