--
-- Search Module SQLite Database for Phire CMS 2.0
--

--  --------------------------------------------------------

--
-- Set database encoding
--

PRAGMA encoding = "UTF-8";
PRAGMA foreign_keys = ON;

-- --------------------------------------------------------

--
-- Table structure for table "searches"
--

CREATE TABLE IF NOT EXISTS "[{prefix}]searches" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "keywords" varchar NOT NULL,
  "results" integer NOT NULL,
  "timestamp" integer NOT NULL,
  UNIQUE ("id")
) ;

INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('[{prefix}]searches', 20000);

-- --------------------------------------------------------
