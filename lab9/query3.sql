CREATE VIEW top_eqippers AS
    SELECT climber_id, COUNT(*) AS num_developed
    FROM developed_climbs
        GROUP BY climber_id
        ORDER BY num_developed DESC
        LIMIT 3;

SELECT * FROM top_eqippers;
