CREATE TABLE teams(
                      id INTEGER PRIMARY KEY AUTOINCREMENT,
                      name VARCHAR(50) NOT NULL
);

CREATE TABLE matches
(
    id     INTEGER PRIMARY KEY AUTOINCREMENT,
    team0  INTEGER NOT NULL,
    team1  INTEGER NOT NULL,
    score0 INTEGER NOT NULL,
    score1 INTEGER NOT NULL,
    date   DATETIME
);
