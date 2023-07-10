cls
cd C:\Program Files\PostgreSQL\8.3\bin\
pg_restore.exe -i -h localhost -p 5432 -U postgres -d bdhel -v 
rem "C:\xx\bdhel.backup"