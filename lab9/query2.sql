SET FOREIGN_KEY_CHECKS=0;

-- Create a temporary table to store the climb_ids of the rows to be deleted
CREATE TEMPORARY TABLE temp_climb_ids AS (
    SELECT climb_id FROM developed_climbs
    WHERE developed_date >= NOW() - INTERVAL 1 YEAR
);

DELETE FROM developed_climbs 
    WHERE climb_id IN (SELECT climb_id FROM temp_climb_ids);

DELETE FROM climbs 
    WHERE climb_id IN (SELECT climb_id FROM temp_climb_ids);

DROP TABLE temp_climb_ids;

SET FOREIGN_KEY_CHECKS=1;
     
