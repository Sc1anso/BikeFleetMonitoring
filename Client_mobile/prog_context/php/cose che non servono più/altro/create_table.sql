SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

CREATE SCHEMA mobike;


ALTER SCHEMA mobike OWNER TO postgres;

SET search_path = mobike, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

CREATE TABLE rastrelliere (
    id integer,
    name character varying(200),
	max_bici integer,
    lat double precision,
    lon double precision,
    geog public.geography(Point,4326),
	geom public.geometry(Point,4326)
);


ALTER TABLE mobike.rastrelliere OWNER TO postgres;