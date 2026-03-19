# data_models/models.py
from sqlalchemy.orm import declarative_base, relationship
from sqlalchemy import Column, String, DateTime, ForeignKey
import uuid
from datetime import datetime

Base = declarative_base()

def generate_uuid():
    return str(uuid.uuid4())

def generate_now():
    return datetime.now().strftime("%d-%m-%y %H:%M:%S")

class User(Base):
    __tablename__ = 'user'

    id = Column(String, primary_key=True, default=generate_uuid)
    name = Column(String, nullable=False)
    created = Column(String, nullable=False, default=generate_now)
    email = Column(String, nullable=False, unique=True)

    tasks = relationship("Task")

    def dict(self):
        d = {"id":self.id,
             "name":self.name,
             "created":self.created,
             "email":self.email}
        return d

class Task(Base):
    __tablename__ = 'task'

    id = Column(String, primary_key=True, default=generate_uuid)
    created = Column(String, nullable=False, default=generate_now)
    updated = Column(DateTime, nullable=True)
    task = Column(String, nullable=False)
    status = Column(String, nullable=False)
    priority = Column(String, nullable=False)
    deadline = Column(DateTime, nullable=False)

    user_id = Column(String, ForeignKey("user.id"))

    def dict(self):
        return {
                "id": self.id,
                "created": self.created,
                "updated": self.updated,
                "task": self.task,
                "status": self.status,
                "priority": self.priority,
                "deadline": self.deadline,
                "user_id": self.user_id
                }
