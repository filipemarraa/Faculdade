# controlador.py
from crud.crud import inserir_tasks, mostrar_tasks, get_userid, ler_user
from data_models.models import User, Task, Base
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from datetime import datetime

DATABASE_URL = "sqlite:///base_tarefas.db"
engine = create_engine(DATABASE_URL, echo=True)
SessionLocal = sessionmaker(bind=engine)

Base.metadata.create_all(bind=engine)

def main():
    session = SessionLocal()
    
    user_name = "Luca"
    user_email = "luca@example.com"
    
    user_id = get_userid(user_name)
    
    if not user_id:
        try:
            novo_usuario = User(name=user_name, email=user_email)
            session.add(novo_usuario)
            session.commit()
            print(f"Usuário '{user_name}' criado com sucesso.")
            user_id = novo_usuario.id
        except Exception as e:
            session.rollback()
            print(f"Erro ao criar o usuário: {e}")
            return  
    
    if user_id:
        tarefas = [
            Task(
                task="Estudar SQLAlchemy",
                status="Incompleta",
                priority="Alta",
                created=datetime.now().strftime("%d-%m-%y %H:%M:%S"),
                updated=datetime.now(),  # Definindo 'updated' ao criar a tarefa
                deadline=datetime.strptime("30-09-2024 23:59:59", "%d-%m-%Y %H:%M:%S"),
                user_id=user_id
            ),
            Task(
                task="Finalizar Projeto de Tarefas",
                status="Incompleta",
                priority="Média",
                created=datetime.now().strftime("%d-%m-%y %H:%M:%S"),
                updated=datetime.now(),  # Definindo 'updated' ao criar a tarefa
                deadline=datetime.strptime("01-10-2024 23:59:59", "%d-%m-%Y %H:%M:%S"),
                user_id=user_id
            )
        ]
        inserir_tasks(tarefas)
        print("\nTarefas inseridas com sucesso!")

    print("\nListando todas as tarefas:")
    mostrar_tasks(Task)
    
    session.close()

if __name__ == "__main__":
    main()
