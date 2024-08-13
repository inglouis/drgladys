cls
C:
cd C:\Program Files\PostgreSQL\9.6\bin\
pg_dump.exe --host localhost --port 5432 --username "postgres" --role "postgres" --no-password  --format custom --blobs --verbose --file "C:\DraRosana\bak\dermatologia.backup" "dermatologia"
cls
