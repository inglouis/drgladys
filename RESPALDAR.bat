cls
C:
cd C:\Program Files\PostgreSQL\9.6\bin\
set pgpassword=123456
pg_dump.exe --host localhost --port 5432 --username "postgres" --role "postgres" --no-password --format custom --blobs --verbose --file "C:\respaldos\oftalmologia.backup" "drGladys"

cd\
cd respaldos
SET hoy=%DATE%
SET hoy=%hoy:/= %
copy oftalmologia.backup "oftalmologia.backup %hoy%.backup"


cls
