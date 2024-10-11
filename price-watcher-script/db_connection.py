import mysql.connector

def get_db_connection():
    connection = mysql.connector.connect(
        host='172.17.0.2',
        #host='0.0.0.0',
        user='root',
        password='La-vie-est-belle-66',
        #password='Lavieestbelle',
        database='price-watcher'
    )
    return connection
