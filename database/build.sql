CREATE TABLE teams(
                      id INTEGER PRIMARY KEY AUTOINCREMENT,
                      name VARCHAR(50) NOT NULL
);

CREATE TABLE matches(
    id     INTEGER PRIMARY KEY AUTOINCREMENT,
    team0  INTEGER NOT NULL,
    team1  INTEGER NOT NULL,
    score0 INTEGER NOT NULL,
    score1 INTEGER NOT NULL,
    date   DATETIME,
    FOREIGN KEY (team0) REFERENCES teams(id),
    FOREIGN KEY (team1) REFERENCES teams(id),
    UNIQUE (team0, team1),
    CHECK(team0 != team1)
    );
