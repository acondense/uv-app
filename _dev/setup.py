from sqlalchemy import create_engine
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy import Column, Integer, String,\
    ForeignKey, Time, Date, DateTime
from sqlalchemy.orm import sessionmaker
from faker import Faker
from random import randint
from datetime import datetime
from sqlalchemy.sql import func

Base = declarative_base()


class Location(Base):
    __tablename__ = 'location'
    id = Column(Integer, primary_key=True)
    name = Column(String(200))
    address = Column(String(200))
    image = Column(String(200))


class Ride(Base):
    __tablename__ = 'ride'
    id = Column(Integer, primary_key=True)
    start_id = Column(Integer, ForeignKey('location.id'))
    end_id = Column(Integer, ForeignKey('location.id'))
    time = Column(Time)
    date = Column(Date)
    seats = Column(Integer, default=1)
    info = Column(String(500))
    timestamp = Column(DateTime, onupdate=func.utc_timestamp(),
                       server_default=func.now())


# Setup connection
Session = sessionmaker()
engine = create_engine("mysql+pymysql://root:@localhost/uv_dev",
                       isolation_level="READ UNCOMMITTED")
Session.configure(bind=engine)
session = Session()

Base.metadata.drop_all(engine)
Base.metadata.create_all(engine)


# Insert seed data
fake = Faker()

# locations
N_LOC_IMG = 6
images = ['placeholder-' + str(i) + '.jpg' for i in range(0, N_LOC_IMG)]
for i in range(0, 10):
    location = Location(name=fake.city(), address=fake.address(),
                        image=images[randint(0, N_LOC_IMG - 1)])
    session.add(location)
session.commit()

# rides
for i in range(0, 10):
    count = session.query(Location).count()
    i1 = randint(0, count) - 1
    i2 = randint(0, count) - 1
    while i1 == i2:
        i2 = randint(0, count)
    start_location = session.query(Location)[i1]
    end_location = session.query(Location)[i2]
    ride = Ride(start_id=start_location.id,
                end_id=end_location.id,
                date=datetime.now().date(),
                time=datetime.now().time(),
                seats=16,
                info='PLATE NO. 699')
    session.add(ride)
session.commit()
