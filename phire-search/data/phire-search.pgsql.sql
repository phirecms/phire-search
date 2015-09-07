--
-- Search Module PostgreSQL Database for Phire CMS 2.0
--

-- --------------------------------------------------------

--
-- Table structure for table "searches"
--

CREATE SEQUENCE search_id_seq START 20001;

CREATE TABLE IF NOT EXISTS "[{prefix}]searches" (
  "id" integer NOT NULL DEFAULT nextval('search_id_seq'),
  "keywords" varchar(255) NOT NULL,
  "results" integer NOT NULL,
  "timestamp" integer NOT NULL,
  PRIMARY KEY ("id")
) ;

ALTER SEQUENCE search_id_seq OWNED BY "[{prefix}]searches"."id";

-- --------------------------------------------------------
