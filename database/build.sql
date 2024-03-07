DROP TABLE IF EXISTS ranking;
DROP TABLE IF EXISTS matches;
DROP TABLE IF EXISTS teams;

CREATE TABLE teams(
                      id int PRIMARY KEY AUTO_INCREMENT,
                      name VARCHAR(50) NOT NULL
);

CREATE TABLE matches(
    id     int PRIMARY KEY AUTO_INCREMENT,
    team0  int NOT NULL,
    team1  int NOT NULL,
    score0 int NOT NULL,
    score1 int NOT NULL,
    date   DATETIME,
    FOREIGN KEY (team0) REFERENCES teams(id),
    FOREIGN KEY (team1) REFERENCES teams(id),
    UNIQUE (team0, team1),
    CHECK(team0 != team1)
    );

CREATE TABLE ranking(
    team_id int PRIMARY KEY,
    position int NOT NULL,
    match_played_count int NOT NULL,
    match_won_count int NOT NULL,
    match_lost_count int NOT NULL,
    draw_count int NOT NULL,
    goal_for_count int NOT NULL,
    goal_against_count int NOT NULL,
    goal_difference int NOT NULL,
    points int NOT NULL,
    FOREIGN KEY (team_id) REFERENCES teams(id),
    UNIQUE(position)
);
