CREATE OR REPLACE FUNCTION principales.historias_nuevos_reportes()
  RETURNS trigger AS
$BODY$
    BEGIN
        IF (TG_OP = 'INSERT') THEN

		INSERT INTO principales.reportes(id_historia) values (NEW.id_historia);

		RETURN NEW;

        END IF;

        RETURN NULL;
    END;

$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION principales.historias_nuevos_reportes()
  OWNER TO postgres;