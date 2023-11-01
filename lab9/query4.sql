USE red_river_climbs;
DROP VIEW IF EXISTS all_climbs;

-- Show climb_name, climb_grade, length, crag_name, first_ascent, developed name

CREATE VIEW all_climbs AS
    SELECT climbs.climb_name, climbs.climb_grade, climbs.climb_len_ft, climbs.crag_name, 
    CONCAT(first_ascent_climbers.climber_first_name, ' ', first_ascent_climbers.climber_last_name) AS 'First ascent by',
    CONCAT(developer_climbers.climber_first_name, ' ', developer_climbers.climber_last_name) AS 'Developed by'
    FROM climbs
        JOIN first_ascents ON climbs.climb_id = first_ascents.climb_id
        JOIN climbers AS first_ascent_climbers ON first_ascents.climber_id = first_ascent_climbers.climber_id
        JOIN developed_climbs ON climbs.climb_id = developed_climbs.climb_id
        JOIN climbers AS developer_climbers ON developed_climbs.climber_id = developer_climbers.climber_id;

SELECT * FROM all_climbs;
