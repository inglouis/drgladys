CREATE OR REPLACE FUNCTION ppal.historias_reportes_nuevo_renglon()
  RETURNS trigger AS
$BODY$
BEGIN
    IF (TG_OP = 'INSERT') THEN
    --IF NEW.id_historia <> OLD.id_historia THEN
        INSERT INTO principales.reportes(id_historia)
        VALUES(NEW.id_historia);
    END IF;
    
    RETURN NEW;
    
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION ppal.historias_reportes_nuevo_renglon()
  OWNER TO postgres;


-----------------------------------------------------------
DROP TRIGGER historias_reportes_nuevo_renglon on principales.historias;

  CREATE TRIGGER historias_reportes_nuevo_renglon
  AFTER INSERT
  ON principales.historias
  FOR EACH ROW
  EXECUTE PROCEDURE ppal.historias_reportes_nuevo_renglon();
