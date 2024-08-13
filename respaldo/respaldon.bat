cls
set pgpassword=123456
cd C:\Program Files\PostgreSQL\9.6\bin
pg_dump.exe -i -h localhost -p 5432 -U postgres -F c -b -v -f "C:\DraRosana\bak\dermatologia.backup" 
set FECHA=%DATE% %TIME%
set FECHA=%FECHA:/=%
set FECHA=%FECHA::=-%
set FECHA=%FECHA:.=-%
ren C:\DraRosana\bak\dermatologia.backup "dermatologia%FECHA%".backup
cls
