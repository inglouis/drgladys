CREATE OR REPLACE FUNCTION ppal.procesar_presentaciones_recipes(medicamentos jsonb)
  RETURNS bigint AS
$BODY$
	DECLARE 

		--EXISTE UNA PRESENTACION PARA EL MEDICAMENTOS
		existe_presentacion BIGINT;

		--VARIABLES
		presentaciones jsonb;
		codigo_medicamento bigint;
		
	BEGIN

		raise notice 'comprobante: %  %', (datos->21)::character varying(100), E'\n'; 
		--(datos->'servicios'->longitud->>'id_servicio')::integer
		--raise notice 'Value: %  %', 'paso', E'\n';

		--variables de la lista de datos
		id_presupuesto_datos = (datos->>15)::bigint;
		--------------------------------
		
		necesita_kit = (select requiere_kit from miscelaneos.areas_facturas where id_area = (datos->>20)::bigint);
		existe_kit_confirmado = (select true from inventario.ordenes_facturadas t where t.id_presupuesto = id_presupuesto_datos and status = 'A');

		raise notice 'necesita kit: %  %', necesita_kit, E'\n'; 
		raise notice 'existe kit: %  %', existe_kit_confirmado, E'\n';

		-------------------------------
		-------------------------------
		--PASO 1: ACTUALIZAR EL STATUS DEL PRESUPUESTO A CONFIRMADO
		-------------------------------

		UPDATE presupuestos.presupuesto 
		SET 
			status = 'C',
			abonos = (datos->>35)::jsonb
		WHERE id_presupuesto = id_presupuesto_datos;

		-------------------------------
		-------------------------------
		--PASO 2: ACTUALIZAR EL STATUS kit_facturado_status a TRUE
		-------------------------------

		IF necesita_kit = true THEN

			UPDATE presupuestos.presupuesto SET kit_facturado_status = true where id_presupuesto = id_presupuesto_datos;
			UPDATE inventario.ordenes_confirmadas SET status = 'C' where id_presupuesto = id_presupuesto_datos;
			PERFORM ppal.restar_inventario((datos->>34)::jsonb);

		END IF;

		-------------------------------
		-------------------------------
		--PASO 3: INSERTAR FACTURA
		-------------------------------

		insert into facturacion.facturas(
			presupuesto_copia,
			egreso,
			materiales,
			normas_cirugia,
			normas_retina,
			normas_laser,
			exalab,
			exalab_adulto,
			exalab_nino,
			informe,
			informe_descripcion,
			preoperatorio,
			preoperatorio_cirugia,
			torax,
			fecha,
			id_presupuesto,
			id_historia,
			id_cirugia,
			id_baremo,
			id_seguro,
			id_area,
			nomb_resp,
			cedu_resp,
			dire_resp,
			tele_resp,
			detalles,
			detalle_honorarios,
			detalle_servicios,
			totales,
			subtotales,
			subtotal_descuento,
			subtotal_paciente,
			subtotal_empresa,
			conversiones,
			fecha_generacion
		) VALUES (
			upper(trim( (datos->>0)::character varying(1) )),
			upper(trim( (datos->>1)::character varying(1) )),
			upper(trim( (datos->>2)::character varying(1) )),
			upper(trim( (datos->>3)::character varying(1) )),
			upper(trim( (datos->>4)::character varying(1) )),
			upper(trim( (datos->>5)::character varying(1) )),
			upper(trim( (datos->>6)::character varying(1) )),
			upper(trim( (datos->>7)::character varying(1) )),
			upper(trim( (datos->>8)::character varying(1) )),
			upper(trim( (datos->>9)::character varying(1) )),
			upper(trim( (datos->>10)::character varying(1) )),
			upper(trim( (datos->>11)::character varying(1) )),
			(datos->>12)::character varying(1),
			upper(trim( (datos->>13)::character varying(1) )),
			(datos->>14)::date,
			(datos->>15)::bigint,
			(datos->>16)::bigint,
			(datos->>17)::bigint,
			(datos->>18)::bigint,
			(datos->>19)::bigint,
			(datos->>20)::bigint,
			upper(trim( (datos->>21)::character varying(150) )),
			upper(trim( (datos->>22)::character varying(14) )),
			upper(trim( (datos->>23)::text )),
			(datos->>24)::json,
			upper(trim( (datos->>25)::character varying(100) )),
			(datos->>26)::json,
			(datos->>27)::json,
			(datos->>28)::json,
			(datos->>29)::json,
			(datos->>30)::numeric(14,2),
			(datos->>31)::json,
			(datos->>32)::numeric(14,2),
			(datos->>33)::json,
			current_date
		) returning id_factura INTO id_factura_retornada;

		-------------------------------
		-------------------------------
		--PASO 4: GENERAR RENGLON EN ORDENES_FACTURADAS
		-------------------------------
		
		IF necesita_kit = true THEN

			IF existe_kit_confirmado is null THEN

				INSERT INTO inventario.ordenes_facturadas(
					id_presupuesto, id_factura, kit_orden, fecha, totales, total_ajustado, status 
				) VALUES (
					id_presupuesto_datos,
					id_factura_retornada,
					(datos->>34)::jsonb,
					current_date,
					(datos->>36)::jsonb,
					(datos->>37)::jsonb,
					'A'
				);
				
			ELSEIF existe_kit_confirmado = true THEN
			
				UPDATE inventario.ordenes_facturadas SET
					kit_orden = (datos->>34)::jsonb,
					fecha = current_date,
					totales = (datos->>36)::jsonb,
					total_ajustado = (datos->>37)::jsonb
				WHERE id_presupuesto = id_presupuesto_datos;
				
			END IF;
		
		END IF;
	
		return id_factura_retornada;
	END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION ppal.procesar_presentaciones_recipes(jsonb)
  OWNER TO postgres;